<?php

namespace Tests\Feature;

use App\Enums\Currency;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\Permission;
use App\Enums\Role;
use App\Enums\TicketStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Models\TeamMember;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_order_links_fan_match_tickets_and_payments(): void
    {
        $fan = User::factory()->create();
        $order = Order::factory()->for($fan)->reserved()->create(['quantity' => 2, 'total' => 20]);
        Ticket::factory()->count(2)->for($order)->create();
        $guard = TeamMember::factory()->role(Role::Security)->create(['team_id' => $order->team_id]);
        Payment::factory()->for($order)->create([
            'method' => PaymentMethod::Cash,
            'amount' => 1790000,
            'currency' => Currency::LBP,
            'collected_by' => $guard->id,
            'collected_at' => now(),
        ]);

        $order->refresh();
        $this->assertSame(OrderStatus::Reserved, $order->status);
        $this->assertSame(PaymentMethod::Cash, $order->method);
        $this->assertSame('20.00', $order->total);
        $this->assertCount(2, $order->tickets);
        $this->assertTrue($order->tickets->every(fn (Ticket $t) => $t->status === TicketStatus::Valid
            && $t->match_id === $order->match_id
            && $t->team_id === $order->team_id));
        $this->assertSame($order->match_id, $order->match->id);
        $this->assertCount(2, $fan->tickets);
        $this->assertTrue($order->payments->first()->collector->is($guard));
        $this->assertSame('1790000.00', $order->payments->first()->amount);
    }

    public function test_qr_tokens_are_unique(): void
    {
        $ticket = Ticket::factory()->create();

        $this->expectException(QueryException::class);
        Ticket::factory()->create(['qr_token' => $ticket->qr_token]);
    }

    public function test_team_member_permissions_follow_their_role(): void
    {
        $security = TeamMember::factory()->role(Role::Security)->create();

        $this->assertTrue($security->hasPermission(Permission::ScanTickets));
        $this->assertFalse($security->hasPermission(Permission::RefundOrders));
    }

    public function test_fan_password_is_hashed_and_hidden(): void
    {
        $fan = User::factory()->create(['password' => 'secret-123']);

        $this->assertNotSame('secret-123', $fan->getAttributes()['password']);
        $this->assertArrayNotHasKey('password', $fan->toArray());
    }
}

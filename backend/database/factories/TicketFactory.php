<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'team_id' => fn (array $attributes) => Order::withoutGlobalScopes()->find($attributes['order_id'])->team_id,
            'match_id' => fn (array $attributes) => Order::withoutGlobalScopes()->find($attributes['order_id'])->match_id,
            'zone_id' => fn (array $attributes) => Order::withoutGlobalScopes()->find($attributes['order_id'])->zone_id,
            'holder_name' => fake()->name(),
            'holder_phone' => '+9617'.fake()->numerify('#######'),
            'qr_token' => Str::random(40),
            'status' => TicketStatus::Valid,
        ];
    }
}

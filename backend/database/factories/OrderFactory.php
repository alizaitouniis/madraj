<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Models\FootballMatch;
use App\Models\Order;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'MD-'.fake()->unique()->numberBetween(10000, 99999),
            'match_id' => FootballMatch::factory(),
            'team_id' => fn (array $attributes) => FootballMatch::withoutGlobalScopes()->find($attributes['match_id'])->team_id,
            'user_id' => User::factory(),
            'zone_id' => Zone::factory(),
            'quantity' => 1,
            'total' => 10,
            'method' => PaymentMethod::WishMoney,
            'status' => OrderStatus::Paid,
        ];
    }

    /**
     * Cash at the stadium: reserved until paid at the gate.
     */
    public function reserved(): static
    {
        return $this->state(fn (array $attributes) => [
            'method' => PaymentMethod::Cash,
            'status' => OrderStatus::Reserved,
        ]);
    }
}

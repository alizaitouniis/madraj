<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'team_id' => fn (array $attributes) => Order::withoutGlobalScopes()->find($attributes['order_id'])->team_id,
            'method' => PaymentMethod::WishMoney,
            'amount' => 10,
            'currency' => Currency::USD,
            'status' => PaymentStatus::Succeeded,
        ];
    }
}

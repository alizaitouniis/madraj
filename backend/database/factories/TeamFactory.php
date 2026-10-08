<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\TeamStatus;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $name = 'نادي '.fake()->unique()->lastName(),
            'short_name' => Str::after($name, 'نادي '),
            'slug' => Str::slug(fake()->unique()->words(2, true)),
            'colour' => fake()->hexColor(),
            'status' => TeamStatus::Active,
            'payment_methods' => PaymentMethod::cases(),
        ];
    }
}

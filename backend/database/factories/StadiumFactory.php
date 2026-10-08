<?php

namespace Database\Factories;

use App\Models\Stadium;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Stadium>
 */
class StadiumFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'ملعب '.fake()->lastName(),
            'city' => 'بيروت',
            'opens_minutes_before' => 120,
            'allowed_items' => [],
            'forbidden_items' => [],
        ];
    }
}

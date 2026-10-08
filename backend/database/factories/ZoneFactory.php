<?php

namespace Database\Factories;

use App\Enums\ZoneShape;
use App\Models\Stadium;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Zone>
 */
class ZoneFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stadium_id' => Stadium::factory(),
            'name' => 'المدرج '.fake()->unique()->word(),
            'capacity' => fake()->numberBetween(100, 900),
            'colour' => fake()->hexColor(),
            'shape' => ZoneShape::Straight,
            'x' => 0,
            'y' => 0,
            'width' => 300,
            'height' => 52,
        ];
    }
}

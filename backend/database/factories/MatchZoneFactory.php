<?php

namespace Database\Factories;

use App\Models\FootballMatch;
use App\Models\MatchZone;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MatchZone>
 */
class MatchZoneFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'match_id' => FootballMatch::factory(),
            'team_id' => fn (array $attributes) => FootballMatch::withoutGlobalScopes()->find($attributes['match_id'])->team_id,
            'zone_id' => Zone::factory(),
            'price' => 10,
            'tickets_for_sale' => 100,
            'on_sale' => true,
        ];
    }
}

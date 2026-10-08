<?php

namespace Database\Factories;

use App\Enums\MatchStatus;
use App\Models\FootballMatch;
use App\Models\Stadium;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FootballMatch>
 */
class FootballMatchFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'stadium_id' => Stadium::factory(),
            'opponent_name' => 'نادي '.fake()->lastName(),
            'competition' => 'الدوري الممتاز',
            'kickoff_at' => $kickoff = now()->addWeek()->startOfHour(),
            'sales_open_at' => now()->subDay(),
            'sales_close_at' => $kickoff,
            'max_per_order' => 6,
            'status' => MatchStatus::OnSale,
        ];
    }
}

<?php

namespace Tests\Feature;

use App\Models\FootballMatch;
use App\Models\Order;
use App\Models\Team;
use App\Models\TeamMember;
use App\Support\Tenancy\CurrentTeam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenancyTest extends TestCase
{
    use RefreshDatabase;

    public function test_with_a_current_team_only_that_teams_rows_are_visible(): void
    {
        [$cedars, $other] = Team::factory()->count(2)->create();
        FootballMatch::factory()->count(2)->for($cedars)->create();
        FootballMatch::factory()->for($other)->create();
        Order::factory()->for(FootballMatch::factory()->for($other), 'match')->create();

        app(CurrentTeam::class)->set($cedars);

        $this->assertSame(2, FootballMatch::count());
        $this->assertTrue(FootballMatch::get()->every(fn ($m) => $m->team_id === $cedars->id));
        $this->assertSame(0, Order::count());
    }

    public function test_without_a_current_team_all_rows_are_visible(): void
    {
        FootballMatch::factory()->count(3)->create();

        $this->assertFalse(app(CurrentTeam::class)->has());
        $this->assertSame(3, FootballMatch::count());
    }

    public function test_new_rows_get_the_current_team(): void
    {
        $team = Team::factory()->create();
        app(CurrentTeam::class)->set($team);

        $member = TeamMember::factory()->create(['team_id' => null]);

        $this->assertSame($team->id, $member->team_id);
    }

    public function test_as_runs_with_another_team_and_restores_the_previous_one(): void
    {
        [$a, $b] = Team::factory()->count(2)->create();
        FootballMatch::factory()->for($b)->create();
        $current = app(CurrentTeam::class);
        $current->set($a);

        $count = $current->as($b, fn () => FootballMatch::count());

        $this->assertSame(1, $count);
        $this->assertSame($a->id, $current->id());
        $this->assertSame(0, FootballMatch::count());
    }
}

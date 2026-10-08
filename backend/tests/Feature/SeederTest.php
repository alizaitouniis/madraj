<?php

namespace Tests\Feature;

use App\Enums\MatchStatus;
use App\Enums\Role;
use App\Models\FootballMatch;
use App\Models\PlatformAdmin;
use App\Models\Stadium;
use App\Models\Team;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_stadium_has_the_four_default_zones(): void
    {
        $stadium = Stadium::with('zones')->sole();

        $this->assertSame('ملعب الأرز', $stadium->name);
        $this->assertSame(
            ['المدرج الرئيسي' => 600, 'الدرجة الأولى' => 900, 'المدرج الشمالي' => 540, 'المدرج الجنوبي' => 540],
            $stadium->zones->pluck('capacity', 'name')->all(),
        );
        $this->assertSame(2580, $stadium->zones->sum('capacity'));
    }

    public function test_cedars_fc_has_one_member_per_role(): void
    {
        $team = Team::with('members')->sole();

        $this->assertSame('نادي الأرز', $team->name);
        $this->assertEqualsCanonicalizing(Role::cases(), $team->members->pluck('role')->all());
    }

    public function test_four_upcoming_matches_on_saturdays_with_zone_prices(): void
    {
        $matches = FootballMatch::with('matchZones.zone')->orderBy('kickoff_at')->get();

        $this->assertCount(4, $matches);
        $this->assertSame(
            ['نادي الميناء', 'نجوم طرابلس', 'بيروت سيتي', 'صيدا الرياضي'],
            $matches->pluck('opponent_name')->all(),
        );
        $this->assertSame(
            [MatchStatus::OnSale, MatchStatus::SoldOut, MatchStatus::OnSale, MatchStatus::Scheduled],
            $matches->pluck('status')->all(),
        );

        foreach ($matches as $match) {
            $local = CarbonImmutable::parse($match->kickoff_at)->tz('Asia/Beirut');
            $this->assertTrue($local->isSaturday());
            $this->assertTrue($local->isFuture());
            $this->assertSame(
                ['المدرج الرئيسي' => '100.00', 'الدرجة الأولى' => '50.00', 'المدرج الشمالي' => '10.00', 'المدرج الجنوبي' => '10.00'],
                $match->matchZones->mapWithKeys(fn ($mz) => [$mz->zone->name => $mz->price])->all(),
            );
        }

        $this->assertTrue($matches->last()->sales_open_at->isFuture());
    }

    public function test_demo_accounts_exist(): void
    {
        $this->assertSame(1, PlatformAdmin::count());
        $this->assertTrue(User::sole()->hasVerifiedPhone());
    }
}

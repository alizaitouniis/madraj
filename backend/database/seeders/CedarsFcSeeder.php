<?php

namespace Database\Seeders;

use App\Enums\MatchStatus;
use App\Enums\PaymentMethod;
use App\Enums\Role;
use App\Enums\TeamStatus;
use App\Models\FootballMatch;
use App\Models\Stadium;
use App\Models\Team;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

/**
 * The launch team with its staff (Figma: Staff and roles 10:769) and four home matches
 * (Figma: Matches 3:2). Matches are on the next four Saturdays, at least 3 days ahead.
 */
class CedarsFcSeeder extends Seeder
{
    /** Default price per zone, by zone name. */
    private const PRICES = [
        'المدرج الرئيسي' => 100,
        'الدرجة الأولى' => 50,
        'المدرج الشمالي' => 10,
        'المدرج الجنوبي' => 10,
    ];

    public function run(): void
    {
        $team = Team::create([
            'name' => 'نادي الأرز',
            'short_name' => 'الأرز',
            'slug' => 'cedars-fc',
            'colour' => '#12452F',
            'status' => TeamStatus::Active,
            'payment_methods' => PaymentMethod::cases(),
        ]);

        $staff = [
            ['name' => 'نور حداد', 'email' => 'nour@cedarsfc.example', 'role' => Role::Owner],
            ['name' => 'جو منصور', 'email' => 'joe@cedarsfc.example', 'role' => Role::Manager],
            ['name' => 'رنا قاسم', 'email' => 'rana@cedarsfc.example', 'role' => Role::Finance],
            ['name' => 'علي بزي', 'email' => 'ali@cedarsfc.example', 'role' => Role::BoxOffice],
            ['name' => 'ميرا طنوس', 'email' => 'mira@cedarsfc.example', 'role' => Role::Security],
        ];

        foreach ($staff as $member) {
            $team->members()->create($member + ['password' => 'password']);
        }

        $stadium = Stadium::with('zones')->sole();
        $tz = config('madraj.timezone');
        $now = CarbonImmutable::now($tz);
        $earliest = $now->addDays(3)->startOfDay();
        $firstSaturday = $earliest->isSaturday() ? $earliest : $earliest->next(CarbonImmutable::SATURDAY);

        $matches = [
            ['opponent_name' => 'نادي الميناء', 'opponent_colour' => '#B8102A', 'competition' => 'الدوري الممتاز', 'round' => 'الأسبوع 3', 'week' => 0, 'hour' => 16, 'status' => MatchStatus::OnSale],
            ['opponent_name' => 'نجوم طرابلس', 'opponent_colour' => '#3F4A44', 'competition' => 'كأس لبنان', 'round' => null, 'week' => 1, 'hour' => 15, 'status' => MatchStatus::SoldOut],
            ['opponent_name' => 'بيروت سيتي', 'opponent_colour' => '#1D4E89', 'competition' => 'الدوري الممتاز', 'round' => null, 'week' => 2, 'hour' => 17, 'status' => MatchStatus::OnSale],
            ['opponent_name' => 'صيدا الرياضي', 'opponent_colour' => '#6E4300', 'competition' => 'الدوري الممتاز', 'round' => null, 'week' => 3, 'hour' => 16, 'status' => MatchStatus::Scheduled],
        ];

        foreach ($matches as $data) {
            $kickoff = $firstSaturday->addWeeks($data['week'])->setTime($data['hour'], 0);

            // The last match opens for sale on the Monday before it, at 10:00.
            $salesOpen = $data['status'] === MatchStatus::Scheduled
                ? $kickoff->previous(CarbonImmutable::MONDAY)->setTime(10, 0)
                : $now->subWeek()->startOfDay();

            $match = FootballMatch::create([
                'team_id' => $team->id,
                'stadium_id' => $stadium->id,
                'opponent_name' => $data['opponent_name'],
                'opponent_colour' => $data['opponent_colour'],
                'competition' => $data['competition'],
                'round' => $data['round'],
                'kickoff_at' => $kickoff->utc(),
                'sales_open_at' => $salesOpen->utc(),
                'sales_close_at' => $kickoff->utc(),
                'max_per_order' => config('madraj.max_tickets_per_order'),
                'status' => $data['status'],
            ]);

            foreach ($stadium->zones as $zone) {
                $match->matchZones()->create([
                    'team_id' => $team->id,
                    'zone_id' => $zone->id,
                    'price' => self::PRICES[$zone->name],
                    'tickets_for_sale' => $zone->capacity,
                    'on_sale' => true,
                ]);
            }
        }
    }
}

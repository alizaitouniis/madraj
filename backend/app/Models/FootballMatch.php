<?php

namespace App\Models;

use App\Enums\MatchStatus;
use App\Models\Concerns\BelongsToTeam;
use Database\Factories\FootballMatchFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A match. Named FootballMatch because `match` is a reserved word in PHP; the table is `matches`.
 */
#[Table('matches')]
#[Fillable([
    'team_id', 'stadium_id', 'opponent_name', 'opponent_crest', 'opponent_colour',
    'competition', 'round', 'kickoff_at', 'sales_open_at', 'sales_close_at', 'max_per_order', 'status',
])]
class FootballMatch extends Model
{
    /** @use HasFactory<FootballMatchFactory> */
    use BelongsToTeam, HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'kickoff_at' => 'datetime',
            'sales_open_at' => 'datetime',
            'sales_close_at' => 'datetime',
            'max_per_order' => 'integer',
            'status' => MatchStatus::class,
        ];
    }

    /**
     * @return BelongsTo<Stadium, $this>
     */
    public function stadium(): BelongsTo
    {
        return $this->belongsTo(Stadium::class);
    }

    /**
     * @return HasMany<MatchZone, $this>
     */
    public function matchZones(): HasMany
    {
        return $this->hasMany(MatchZone::class, 'match_id');
    }

    /**
     * @return HasMany<Order, $this>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'match_id');
    }

    /**
     * @return HasMany<Ticket, $this>
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'match_id');
    }
}

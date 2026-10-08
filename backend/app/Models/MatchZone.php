<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTeam;
use Database\Factories\MatchZoneFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * What a team sells in one zone for one match: price, tickets for sale, max per order, on-sale switch.
 */
#[Fillable(['team_id', 'match_id', 'zone_id', 'price', 'tickets_for_sale', 'max_per_order', 'on_sale'])]
class MatchZone extends Model
{
    /** @use HasFactory<MatchZoneFactory> */
    use BelongsToTeam, HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'tickets_for_sale' => 'integer',
            'max_per_order' => 'integer',
            'on_sale' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<FootballMatch, $this>
     */
    public function match(): BelongsTo
    {
        return $this->belongsTo(FootballMatch::class, 'match_id');
    }

    /**
     * @return BelongsTo<Zone, $this>
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }
}

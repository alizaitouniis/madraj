<?php

namespace App\Models\Concerns;

use App\Models\Scopes\TeamScope;
use App\Models\Team;
use App\Support\Tenancy\CurrentTeam;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * For tenant tables (they carry team_id). Scopes queries to the current team
 * and fills team_id on create. See CurrentTeam.
 */
trait BelongsToTeam
{
    public static function bootBelongsToTeam(): void
    {
        static::addGlobalScope(new TeamScope);

        static::creating(function (self $model): void {
            $model->team_id ??= app(CurrentTeam::class)->id();
        });
    }

    /**
     * @return BelongsTo<Team, $this>
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

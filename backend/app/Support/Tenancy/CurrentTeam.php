<?php

namespace App\Support\Tenancy;

use App\Models\Team;

/**
 * The team whose data the current request or job works on.
 *
 * Set it for every staff request (team admin, scanner). When it is set, models
 * using BelongsToTeam only see that team's rows and new rows get its team_id.
 * Fan and platform-admin requests leave it empty and see across teams.
 */
class CurrentTeam
{
    private ?int $id = null;

    public function set(Team|int|null $team): void
    {
        $this->id = $team instanceof Team ? $team->getKey() : $team;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function has(): bool
    {
        return $this->id !== null;
    }

    /**
     * Run a callback with another team as context, then restore the previous one.
     *
     * @template T
     *
     * @param  callable(): T  $callback
     * @return T
     */
    public function as(Team|int|null $team, callable $callback): mixed
    {
        $previous = $this->id;
        $this->set($team);

        try {
            return $callback();
        } finally {
            $this->id = $previous;
        }
    }
}

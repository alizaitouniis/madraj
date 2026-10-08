<?php

namespace App\Models\Scopes;

use App\Support\Tenancy\CurrentTeam;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TeamScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $teamId = app(CurrentTeam::class)->id();

        if ($teamId !== null) {
            $builder->where($model->qualifyColumn('team_id'), $teamId);
        }
    }
}

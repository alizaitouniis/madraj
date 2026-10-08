<?php

namespace App\Models;

use App\Enums\Permission;
use App\Enums\Role;
use App\Models\Concerns\BelongsToTeam;
use Database\Factories\TeamMemberFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Club staff. Logs in to the team admin (session) and the scanner app (Sanctum token).
 */
#[Fillable(['team_id', 'name', 'email', 'phone', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class TeamMember extends Authenticatable
{
    /** @use HasFactory<TeamMemberFactory> */
    use BelongsToTeam, HasApiTokens, HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => Role::class,
            'password' => 'hashed',
            'last_active_at' => 'datetime',
        ];
    }

    public function hasPermission(Permission $permission): bool
    {
        return $this->role->can($permission);
    }
}

<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\TeamStatus;
use Database\Factories\TeamFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A club with its own account (the tenant).
 */
#[Fillable(['name', 'short_name', 'slug', 'crest', 'colour', 'status', 'wishmoney_merchant_id', 'payment_methods'])]
class Team extends Model
{
    /** @use HasFactory<TeamFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => TeamStatus::class,
            'payment_methods' => AsEnumCollection::of(PaymentMethod::class),
        ];
    }

    /**
     * @return HasMany<TeamMember, $this>
     */
    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    /**
     * @return HasMany<FootballMatch, $this>
     */
    public function matches(): HasMany
    {
        return $this->hasMany(FootballMatch::class);
    }

    /**
     * @return HasMany<Order, $this>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}

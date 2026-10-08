<?php

namespace App\Models;

use Database\Factories\StadiumFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * The stadium (one for now), managed by the platform admin.
 *
 * parking is a list of {name, description, price}; price stays null until known.
 */
#[Fillable([
    'name', 'address', 'city', 'map_link', 'opens_minutes_before',
    'parking', 'parking_note', 'allowed_items', 'forbidden_items', 'entry_note',
    'accessibility_note', 'accessibility_phone',
])]
class Stadium extends Model
{
    /** @use HasFactory<StadiumFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'opens_minutes_before' => 'integer',
            'parking' => 'array',
            'allowed_items' => 'array',
            'forbidden_items' => 'array',
        ];
    }

    /**
     * @return HasMany<Zone, $this>
     */
    public function zones(): HasMany
    {
        return $this->hasMany(Zone::class)->orderBy('sort');
    }
}

<?php

namespace App\Models;

use App\Enums\ZoneShape;
use Database\Factories\ZoneFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A stand drawn in the stadium builder. Geometry is in canvas units, see the migration.
 */
#[Fillable(['stadium_id', 'name', 'description', 'capacity', 'colour', 'shape', 'x', 'y', 'width', 'height', 'rotation', 'sort'])]
class Zone extends Model
{
    /** @use HasFactory<ZoneFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
            'shape' => ZoneShape::class,
            'x' => 'float',
            'y' => 'float',
            'width' => 'float',
            'height' => 'float',
            'rotation' => 'float',
            'sort' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Stadium, $this>
     */
    public function stadium(): BelongsTo
    {
        return $this->belongsTo(Stadium::class);
    }
}

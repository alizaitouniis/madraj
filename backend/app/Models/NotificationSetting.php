<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A fan's push notification switches. All on by default.
 */
#[Table(key: 'user_id', incrementing: false)]
#[Fillable(['user_id', 'on_sale', 'day_before', 'two_hours', 'stadium_opens', 'few_left'])]
class NotificationSetting extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'on_sale' => 'boolean',
            'day_before' => 'boolean',
            'two_hours' => 'boolean',
            'stadium_opens' => 'boolean',
            'few_left' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

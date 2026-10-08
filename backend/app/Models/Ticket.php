<?php

namespace App\Models;

use App\Enums\TicketStatus;
use App\Models\Concerns\BelongsToTeam;
use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One attendee's ticket with its own QR code. The QR holds only qr_token.
 */
#[Fillable([
    'order_id', 'team_id', 'match_id', 'zone_id', 'holder_name', 'holder_phone',
    'qr_token', 'status', 'checked_in_at', 'checked_in_by',
])]
class Ticket extends Model
{
    /** @use HasFactory<TicketFactory> */
    use BelongsToTeam, HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => TicketStatus::class,
            'checked_in_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Order, $this>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
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

    /**
     * @return BelongsTo<TeamMember, $this>
     */
    public function checkedInBy(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'checked_in_by');
    }
}

<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Concerns\BelongsToTeam;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Money received for an order: a WishMoney or card transaction, or cash taken at the gate.
 */
#[Fillable(['order_id', 'team_id', 'method', 'amount', 'currency', 'status', 'provider_ref', 'collected_by', 'collected_at'])]
class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use BelongsToTeam, HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'method' => PaymentMethod::class,
            'amount' => 'decimal:2',
            'currency' => Currency::class,
            'status' => PaymentStatus::class,
            'collected_at' => 'datetime',
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
     * Staff member who took the cash.
     *
     * @return BelongsTo<TeamMember, $this>
     */
    public function collector(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'collected_by');
    }
}

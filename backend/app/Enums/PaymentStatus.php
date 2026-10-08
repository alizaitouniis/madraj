<?php

namespace App\Enums;

/** State of a single payment attempt. */
enum PaymentStatus: string
{
    case Pending = 'pending';
    case Succeeded = 'succeeded';
    case Failed = 'failed';
    case Refunded = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'قيد المعالجة',
            self::Succeeded => 'ناجح',
            self::Failed => 'فشل',
            self::Refunded => 'مسترد',
        };
    }
}

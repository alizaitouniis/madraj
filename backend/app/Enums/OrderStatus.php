<?php

namespace App\Enums;

/** Lifecycle of an order. Cash orders stay `reserved` until paid at the gate or released at kick-off. */
enum OrderStatus: string
{
    case PendingPayment = 'pending_payment';
    case Paid = 'paid';
    case Reserved = 'reserved';
    case Expired = 'expired';
    case Refunded = 'refunded';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PendingPayment => 'بانتظار الدفع',
            self::Paid => 'مدفوع',
            self::Reserved => 'محجوز، الدفع في الملعب',
            self::Expired => 'منتهي',
            self::Refunded => 'مسترد',
            self::Cancelled => 'ملغى',
        };
    }
}

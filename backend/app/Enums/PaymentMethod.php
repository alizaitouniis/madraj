<?php

namespace App\Enums;

/** How a fan pays. The brand name is always written `WishMoney`. */
enum PaymentMethod: string
{
    case WishMoney = 'wishmoney';
    case Card = 'card';
    case Cash = 'cash';

    public function label(): string
    {
        return match ($this) {
            self::WishMoney => 'WishMoney',
            self::Card => 'بطاقة',
            self::Cash => 'نقداً في الملعب',
        };
    }
}

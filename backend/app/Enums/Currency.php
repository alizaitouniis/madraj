<?php

namespace App\Enums;

/** Currencies accepted. Card and WishMoney are USD; cash at the gate can be USD or LBP. */
enum Currency: string
{
    case USD = 'USD';
    case LBP = 'LBP';

    public function label(): string
    {
        return match ($this) {
            self::USD => 'دولار',
            self::LBP => 'ليرة لبنانية',
        };
    }
}

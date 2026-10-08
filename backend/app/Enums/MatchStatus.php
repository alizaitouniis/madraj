<?php

namespace App\Enums;

/** Lifecycle of a match. */
enum MatchStatus: string
{
    case Draft = 'draft';
    case Scheduled = 'scheduled';
    case OnSale = 'on_sale';
    case SoldOut = 'sold_out';
    case Finished = 'finished';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'مسودة',
            self::Scheduled => 'مجدولة',
            self::OnSale => 'متاحة للبيع',
            self::SoldOut => 'نفدت التذاكر',
            self::Finished => 'انتهت',
        };
    }
}

<?php

namespace App\Enums;

/** Stand shape in the stadium builder. */
enum ZoneShape: string
{
    case Straight = 'straight';
    case Corner = 'corner';
    case Curved = 'curved';

    public function label(): string
    {
        return match ($this) {
            self::Straight => 'مستقيم',
            self::Corner => 'زاوية',
            self::Curved => 'منحني',
        };
    }
}

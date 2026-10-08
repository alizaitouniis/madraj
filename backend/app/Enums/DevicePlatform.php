<?php

namespace App\Enums;

/** Push notification platform. */
enum DevicePlatform: string
{
    case Android = 'android';
    case Ios = 'ios';

    public function label(): string
    {
        return match ($this) {
            self::Android => 'Android',
            self::Ios => 'iOS',
        };
    }
}

<?php

namespace App\Enums;

/** Account state of a team (club). */
enum TeamStatus: string
{
    case Active = 'active';
    case Invited = 'invited';
    case Paused = 'paused';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'نشط',
            self::Invited => 'مدعو',
            self::Paused => 'موقوف',
        };
    }
}

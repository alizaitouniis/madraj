<?php

namespace App\Enums;

/** State of a single ticket (one per attendee). */
enum TicketStatus: string
{
    case Valid = 'valid';
    case Used = 'used';
    case Void = 'void';

    public function label(): string
    {
        return match ($this) {
            self::Valid => 'صالحة',
            self::Used => 'مستخدمة',
            self::Void => 'ملغاة',
        };
    }
}

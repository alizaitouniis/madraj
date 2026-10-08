<?php

namespace App\Enums;

/** Why a verification code was sent. */
enum OtpPurpose: string
{
    case Register = 'register';
    case ChangePhone = 'change_phone';
    case ResetPassword = 'reset_password';

    public function label(): string
    {
        return match ($this) {
            self::Register => 'التسجيل',
            self::ChangePhone => 'تغيير رقم الهاتف',
            self::ResetPassword => 'إعادة تعيين كلمة المرور',
        };
    }
}

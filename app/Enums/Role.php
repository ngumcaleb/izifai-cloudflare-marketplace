<?php

namespace App\Enums;

enum Role: string
{
    case Superadmin = 'Superadmin';
    case User = 'User';

    public function label(): string
    {
        return match ($this) {
            self::Superadmin => 'Super Admin',
            self::User => 'User',
        };
    }
}

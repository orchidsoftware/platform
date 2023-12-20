<?php

namespace Orchid\Tests\App\Enums;

enum RoleNames: string
{
    case Admin = 'admin';
    case User = 'user';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::User => 'Regular user',
        };
    }
}

<?php

namespace App\Http\Enums;

enum ShopStatus: int
{
    case ACTIVE   = 1;
    case INACTIVE = 2;

    public function label(): string
    {
        return match ($this) {
            self::INACTIVE => 'Inactive',
            self::ACTIVE   => 'Active',
        };
    }
}

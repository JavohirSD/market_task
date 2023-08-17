<?php

namespace App\Http\Enums;

enum MerchantStatus: int
{
    case ACTIVE   = 1;
    case INACTIVE = 2;

    public function label(): string
    {
        return match ($this) {
            MerchantStatus::INACTIVE => 'Inactive',
            MerchantStatus::ACTIVE   => 'Active',
        };
    }
}

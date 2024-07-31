<?php

namespace App\Enums;

enum ShippingCarrier: string
{
    case JUMIA = 'jumia colis express';
    case YANGO = 'yango delivery';
    case UTB = 'UTB express';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::JUMIA => 'Jumia Colis Express',
            self::YANGO => 'Yango Delivery',
            self::UTB => 'UTB Express',
            self::OTHER => 'Other',
        };
    }
}

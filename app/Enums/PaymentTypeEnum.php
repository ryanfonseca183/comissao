<?php

namespace App\Enums;

class PaymentTypeEnum
{
    const VIDA = 1;
    const FIXO = 2;
    const METRO = 3;

    public static function array()
    {
        return [
            self::VIDA => 'Vida',
            self::FIXO => 'Fixo',
            self::METRO => 'm²',
        ];
    }
    
    public static function label($valor)
    {
        return PaymentTypeEnum::array()[$valor];
    }
}

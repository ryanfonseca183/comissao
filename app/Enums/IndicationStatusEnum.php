<?php

namespace App\Enums;

class IndicationStatusEnum
{
    public static function array()
    {
        return [
            0 => 'Pendente',
            1 => 'Em análise',
            2 => 'Fechado',
            3 => 'Recusado',
        ];
    }
   
    public static function label($valor)
    {
        return IndicationStatusEnum::array()[$valor];
    }
}

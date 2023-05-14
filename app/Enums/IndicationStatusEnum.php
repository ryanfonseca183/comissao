<?php

namespace App\Enums;

class IndicationStatusEnum
{
    const PENDENTE = 0;
    const ANALISE = 1;
    const FECHADO = 2;
    const RECUSADO = 3;
    const CANCELADO = 4;

    public static function array()
    {
        return [
            self::PENDENTE => 'Pendente',
            self::ANALISE => 'Em análise',
            self::FECHADO => 'Fechado',
            self::RECUSADO => 'Recusado',
            self::CANCELADO => 'Cancelado',
        ];
    }
   
    public static function label($valor)
    {
        return IndicationStatusEnum::array()[$valor];
    }
}

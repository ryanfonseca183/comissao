<?php

namespace App\Enums;

class IndicationStatusEnum
{
    const PENDENTE = 0;
    const ANALISE = 1;
    const ORCADO = 2;
    const FECHADO = 3;
    const RECUSADO = 4;
    const RESCINDIDO = 5;

    public static function array()
    {
        return [
            self::PENDENTE => 'Pendente',
            self::ANALISE => 'Em análise',
            self::ORCADO => 'Orçado',
            self::FECHADO => 'Fechado',
            self::RECUSADO => 'Recusado',
            self::RESCINDIDO => 'Rescindido',
        ];
    }

    public static function except($status)
    {
        return array_filter(self::array(), function($value) use($status) {
            return ! in_array($value, $status);
        }, ARRAY_FILTER_USE_KEY);
    }
   
    public static function label($valor)
    {
        return IndicationStatusEnum::array()[$valor];
    }
}

<?php

namespace App\Enums;

class BudgetStatusEnum
{
    const PENDENTE = 0;
    const FECHADO = 1;
    const RECUSADO = 2;

    public static function array()
    {
        return [
            self::PENDENTE => 'Pendente',
            self::FECHADO => 'Fechado',
            self::RECUSADO => 'Recusado',
        ];
    }
   
    public static function label($valor)
    {
        return BudgetStatusEnum::array()[$valor];
    }
}

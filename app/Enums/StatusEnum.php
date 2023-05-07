<?php

namespace App\Enums;

class StatusEnum
{
    public static function array()
    {
        return [
            1 => 'Ativo',
            0 => 'Inativo',
        ];
    }
    public static function keys() 
    {
        return array_keys(StatusEnum::array());
    }
    public static function label($valor)
    {
        return StatusEnum::array()[$valor];
    }
}

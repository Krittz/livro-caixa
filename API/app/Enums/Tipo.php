<?php

namespace App\Enums;

enum Tipo: string
{
    case ENTRADA = 'entrada';
    case SAIDA = 'saida';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

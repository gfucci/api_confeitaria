<?php

namespace App\Enums;

enum CandyEnum: string
{
    CASE BRIGADEIRO = "brigadeiro";
    CASE BOLO_FATIA = "fatia de bolo";
    CASE TORTA = "torta";
    CASE SORVETE = "sorvete";

    public static function getArrayValues(): array
    {
        return [
            CandyEnum::BRIGADEIRO->value,
            CandyEnum::BOLO_FATIA->value,
            CandyEnum::TORTA->value,
            CandyEnum::SORVETE->value,
        ];
    }

    public static function getUnit(string $name) 
    {
        return match ($name) {
            CandyEnum::BRIGADEIRO->value => "g",
            CandyEnum::BOLO_FATIA->value => "slice",
            CandyEnum::TORTA->value => "kg",
            CandyEnum::SORVETE->value => "ml"
        };
    }
}
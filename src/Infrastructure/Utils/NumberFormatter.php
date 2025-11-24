<?php

namespace DevFighters\Utils\Infrastructure\Utils;

class NumberFormatter
{
    public static function format(?string $number): ?string
    {
        if(is_null($number)){
            return null;
        }
        if (str_contains($number, '.')) {
            $number = rtrim($number, '0');
            $number = rtrim($number, '.');
        }

        return $number;
    }
}
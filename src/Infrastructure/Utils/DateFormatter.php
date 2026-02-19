<?php

namespace DevFighters\Utils\Infrastructure\Utils;

class DateFormatter
{
    public static function format(?\DateTimeInterface $date): ?string
    {
        return $date?->format('Y-m-d');
    }
}

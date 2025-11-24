<?php

namespace DevFighters\Utils\Infrastructure\Utils;

use DateTimeInterface;

class DateTimeFormatter {

    public static function format(?DateTimeInterface $date): ?string
    {
        return $date?->format('Y-m-d\TH:i:s.v\Z');
    }
}
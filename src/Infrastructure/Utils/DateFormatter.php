<?php

namespace DevFighters\Utils\Infrastructure\Utils;

use DateTimeInterface;

class DateFormatter {

    public static function format(?DateTimeInterface $date): ?string
    {
        return $date?->format('Y-m-d');
    }

}
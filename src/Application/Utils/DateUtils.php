<?php

namespace DevFighters\Utils\Application\Utils;

use DateTime;

class DateUtils {

    public static function getDate(?string $value): ?DateTime
    {
        if(is_null($value) || trim($value) === ''){
            return null;
        }
        return DateTime::createFromFormat('Y-m-d', $value);
    }

}
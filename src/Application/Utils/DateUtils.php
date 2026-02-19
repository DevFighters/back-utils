<?php

namespace DevFighters\Utils\Application\Utils;

use DateTime;

class DateUtils
{
    /**
     * @param non-empty-string|null $value
     *
     * @phpstan-return ($value is null ? null : DateTime)
     */
    public static function getDate(?string $value): ?\DateTime
    {
        if (null === $value || '' === trim($value)) {
            return null;
        }

        $date = \DateTime::createFromFormat('!Y-m-d', $value);

        return $date ?: null;
    }
}

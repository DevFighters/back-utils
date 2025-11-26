<?php

namespace DevFighters\Utils\Application\Utils;

use Symfony\Component\Uid\Uuid;

class TokenUtils
{

    public static function create(int $length = 15): string
    {
        return StringUtils::generateRandomString($length);
    }

    public static function uuidV4(): string
    {
        return Uuid::v4()->toString();
    }
}
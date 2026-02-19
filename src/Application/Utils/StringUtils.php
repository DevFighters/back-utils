<?php

namespace DevFighters\Utils\Application\Utils;

class StringUtils
{
    public static function generateRandomString(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        while (strlen($randomString) < $length) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public static function isBlank(?string $value): bool
    {
        return null === $value || '' === trim($value);
    }

    public static function isNotBlank(?string $value): bool
    {
        return !self::isBlank($value);
    }
}

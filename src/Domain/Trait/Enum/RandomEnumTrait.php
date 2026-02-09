<?php

namespace DevFighters\Utils\Domain\Trait\Enum;

trait RandomEnumTrait
{
    public static function randomOne(): self
    {
        $cases = self::cases();
        $randomKeys = array_rand($cases);

        return $cases[$randomKeys];
    }
}

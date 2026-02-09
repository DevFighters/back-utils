<?php

namespace DevFighters\Utils\Application\Utils;

final class MathUtils
{
    public const int DEFAULT_SCALE = 10;

    /**
     * @param numeric-string $number
     *
     * @return numeric-string
     */
    public static function bcFloor(string $number, int $precision = 0): string
    {
        if ($precision < 0) {
            throw new \InvalidArgumentException('Precision must be 0 or greater.');
        }

        if (0 === $precision) {
            return bcadd($number, '0', 0);
        }

        /** @var numeric-string $factor */
        $factor = bcpow('10', (string) $precision, 0);

        /** @var numeric-string $temp */
        $temp = bcmul($number, $factor, 0);

        return bcdiv($temp, $factor, $precision);
    }

    /**
     * @param numeric-string $number
     *
     * @return numeric-string
     */
    public static function bcResult(string $number): string
    {
        if (str_contains($number, '.')) {
            $number = rtrim($number, '0');
            $number = rtrim($number, '.');
        }

        return $number;
    }

    /**
     * @param int|float|numeric-string $number
     *
     * @return numeric-string
     */
    public static function bcTransform(int|float|string $number): string
    {
        $value = number_format((float) $number, self::DEFAULT_SCALE, '.', '');

        /** @var numeric-string $numeric */
        $numeric = self::bcResult($value);

        return $numeric;
    }

    public function isNumericString(string $value): bool
    {
        return 1 === preg_match('/^[+-]?\d+(\.\d+)?$/', $value);
    }
}

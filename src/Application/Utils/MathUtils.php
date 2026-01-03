<?php

namespace DevFighters\Utils\Application\Utils;

use DateTime;
use InvalidArgumentException;

class MathUtils {

    public const int DEFAULT_SCALE = 10;

    public static function bcFloor(string $number, int $precision = 0): string {
        if ($precision < 0) {
            throw new InvalidArgumentException('Precision must be 0 or greater.');
        }

        if ($precision === 0) {
            return bcadd($number, '0', 0); // Conserve seulement la partie entière
        }

        // Découper le nombre pour conserver uniquement la partie demandée
        $factor = bcpow('10', (string)$precision, 0); // 10^precision
        $temp = bcmul($number, $factor, 0); // Multiplier pour "décaler" la virgule
        return bcdiv($temp, $factor, $precision); // Diviser pour ramener au format initial
    }

    public static function bcResult(string $number):string{
        if (str_contains($number,'.')) {
            $number = rtrim($number,'0');
            $number = rtrim($number,'.');
        }
        return $number;
    }

    public static function bcTransform(int|float|string $number):string{
        $value = number_format($number, self::DEFAULT_SCALE, '.', '');
        return self::bcResult($value);
    }

}
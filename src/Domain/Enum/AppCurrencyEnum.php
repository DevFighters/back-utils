<?php

namespace DevFighters\Utils\Domain\Enum;

use DevFighters\Utils\Domain\Trait\Enum\RandomEnumTrait;

/**
 * @method static self[] cases()  Retourne tous les cas de l'énumération
 */
enum AppCurrencyEnum: int
{

    use RandomEnumTrait;

    case EUR = 1;
    case USD = 2;
    case GBP = 3;
    case THB = 4;

    public function name(): string
    {
        return match ($this) {
            self::EUR => 'euro',
            self::USD => 'dollar',
            self::GBP => 'pound sterling',
            self::THB => 'baht',
        };
    }

    public function symbol(): string
    {
        return match ($this) {
            self::EUR => '€',
            self::USD => '$',
            self::GBP => '£',
            self::THB => '฿',
        };
    }

}

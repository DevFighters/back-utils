<?php

namespace DevFighters\Utils\Domain\Enum;

/**
 * @method static self[] cases()  Retourne tous les cas de l'énumération
 */
enum AppSystemLanguageEnum: int
{

    case fr_FR = 1;
    case en_US = 2;
    case it_IT = 3;
    case es_ES = 4;
    case th_TH = 5;
    case pt_PT = 6;

    public function name(): string
    {
        return match ($this) {
            self::fr_FR => 'Français (France)',
            self::en_US => 'English (United States)',
            self::it_IT => 'Italiano (Italia)',
            self::es_ES => 'Español (España)',
            self::th_TH => 'ไทย (ประเทศไทย)',
            self::pt_PT => 'Português (Portugal)',
        };
    }



}

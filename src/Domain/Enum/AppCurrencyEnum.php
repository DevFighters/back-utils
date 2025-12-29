<?php

namespace DevFighters\Utils\Domain\Enum;

use DevFighters\Utils\Domain\Trait\Enum\RandomEnumTrait;

/**
 * @method static self[] cases()  Retourne tous les cas de l'énumération
 */
enum AppCurrencyEnum: int
{
    use RandomEnumTrait;

    case EUR = 1;   // Euro
    case USD = 2;   // US Dollar
    case GBP = 3;   // British Pound
    case THB = 4;   // Thai Baht
    case JPY = 5;   // Japanese Yen
    case CHF = 6;   // Swiss Franc
    case CAD = 7;   // Canadian Dollar
    case AUD = 8;   // Australian Dollar
    case NZD = 9;   // New Zealand Dollar
    case CNY = 10;  // Chinese Yuan (Renminbi)
    case HKD = 11;  // Hong Kong Dollar
    case SGD = 12;  // Singapore Dollar
    case INR = 13;  // Indian Rupee
    case KRW = 14;  // South Korean Won
    case SEK = 15;  // Swedish Krona
    case NOK = 16;  // Norwegian Krone
    case DKK = 17;  // Danish Krone
    case PLN = 18;  // Polish Zloty
    case CZK = 19;  // Czech Koruna
    case HUF = 20;  // Hungarian Forint
    case MXN = 21;  // Mexican Peso
    case BRL = 22;  // Brazilian Real
    case ZAR = 23;  // South African Rand
    case AED = 24;  // UAE Dirham
    case SAR = 25;  // Saudi Riyal
    case TRY = 26;  // Turkish Lira
    case ILS = 27;  // Israeli Shekel
    case EGP = 28;  // Egyptian Pound
    case IDR = 29;  // Indonesian Rupiah
    case PHP = 30;  // Philippine Peso
    case MYR = 31;  // Malaysian Ringgit
    case VND = 32;  // Vietnamese Dong
    case ARS = 33;  // Argentine Peso
    case CLP = 34;  // Chilean Peso
    case COP = 35;  // Colombian Peso
    case RON = 36;  // Romanian Leu
    case BGN = 37;  // Bulgarian Lev
    case HRK = 38;  // Croatian Kuna (legacy)
    case ISK = 39;  // Icelandic Krona
    case MAD = 40;  // Moroccan Dirham

    public function name(): string
    {
        return match ($this) {
            self::EUR => 'euro',
            self::USD => 'us dollar',
            self::GBP => 'pound sterling',
            self::THB => 'thai baht',
            self::JPY => 'japanese yen',
            self::CHF => 'swiss franc',
            self::CAD => 'canadian dollar',
            self::AUD => 'australian dollar',
            self::NZD => 'new zealand dollar',
            self::CNY => 'chinese yuan',
            self::HKD => 'hong kong dollar',
            self::SGD => 'singapore dollar',
            self::INR => 'indian rupee',
            self::KRW => 'south korean won',
            self::SEK => 'swedish krona',
            self::NOK => 'norwegian krone',
            self::DKK => 'danish krone',
            self::PLN => 'polish zloty',
            self::CZK => 'czech koruna',
            self::HUF => 'hungarian forint',
            self::MXN => 'mexican peso',
            self::BRL => 'brazilian real',
            self::ZAR => 'south african rand',
            self::AED => 'uae dirham',
            self::SAR => 'saudi riyal',
            self::TRY => 'turkish lira',
            self::ILS => 'israeli shekel',
            self::EGP => 'egyptian pound',
            self::IDR => 'indonesian rupiah',
            self::PHP => 'philippine peso',
            self::MYR => 'malaysian ringgit',
            self::VND => 'vietnamese dong',
            self::ARS => 'argentine peso',
            self::CLP => 'chilean peso',
            self::COP => 'colombian peso',
            self::RON => 'romanian leu',
            self::BGN => 'bulgarian lev',
            self::HRK => 'croatian kuna',
            self::ISK => 'icelandic krona',
            self::MAD => 'moroccan dirham',
        };
    }

    public function symbol(): string
    {
        return match ($this) {
            self::EUR => '€',
            self::USD => '$',
            self::GBP => '£',
            self::THB => '฿',
            self::JPY => '¥',
            self::CHF => 'CHF',
            self::CAD => 'CA$',
            self::AUD => 'A$',
            self::NZD => 'NZ$',
            self::CNY => '¥',
            self::HKD => 'HK$',
            self::SGD => 'S$',
            self::INR => '₹',
            self::KRW => '₩',
            self::SEK => 'kr',
            self::NOK => 'kr',
            self::DKK => 'kr',
            self::PLN => 'zł',
            self::CZK => 'Kč',
            self::HUF => 'Ft',
            self::MXN => '$',
            self::BRL => 'R$',
            self::ZAR => 'R',
            self::AED => 'د.إ',
            self::SAR => '﷼',
            self::TRY => '₺',
            self::ILS => '₪',
            self::EGP => '£',
            self::IDR => 'Rp',
            self::PHP => '₱',
            self::MYR => 'RM',
            self::VND => '₫',
            self::ARS => '$',
            self::CLP => '$',
            self::COP => '$',
            self::RON => 'lei',
            self::BGN => 'лв',
            self::HRK => 'kn',
            self::ISK => 'kr',
            self::MAD => 'د.م.',
        };
    }
}

<?php

namespace DevFighters\Utils\Domain\Enum;


use DevFighters\Utils\Domain\Trait\Enum\RandomEnumTrait;

enum AppLanguageEnum: int
{
    use RandomEnumTrait;

    case FR = 1; // Français
    case EN = 2; // Anglais
    case IT = 3; // Italien
    case DE = 4; // Allemand
    case ES = 5; // Espagnol
    case PT = 6; // Portugais
    case NL = 7; // Néerlandais
    case PL = 8; // Polonais
    case RU = 9; // Russe
    case JA = 10; // Japonais
    case ZH = 11; // Chinois
    case KO = 12; // Coréen
    case AR = 13; // Arabe
    case TR = 14; // Turc
    case SV = 15; // Suédois
    case NO = 16; // Norvégien
    case DA = 17; // Danois
    case FI = 18; // Finnois
    case EL = 19; // Grec
    case CS = 20; // Tchèque
    case HU = 21; // Hongrois
    case RO = 22; // Roumain
    case BG = 23; // Bulgare
    case SK = 24; // Slovaque
    case SL = 25; // Slovène
    case HR = 26; // Croate
    case SR = 27; // Serbe
    case HE = 28; // Hébreu
    case HI = 29; // Hindi
    case TH = 30; // Thaï

}

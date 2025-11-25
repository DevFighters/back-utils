<?php

namespace DevFighters\Utils\Domain\Enum;

use DevFighters\Utils\Domain\Trait\Enum\RandomEnumTrait;

/**
 * @method static self[] cases()  Retourne tous les cas de l'énumération
 */
enum AppCountryAdministrativeAreaEnum: int
{
    use RandomEnumTrait;
    case US_AL = 1;
    case US_AK = 2;
    case US_AZ = 3;
    case US_AR = 4;
    case US_CA = 5;
    case US_CO = 6;
    case US_CT = 7;
    case US_DE = 8;
    case US_FL = 9;
    case US_GA = 10;
    case US_HI = 11;
    case US_ID = 12;
    case US_IL = 13;
    case US_IN = 14;
    case US_IA = 15;
    case US_KS = 16;
    case US_KY = 17;
    case US_LA = 18;
    case US_ME = 19;
    case US_MD = 20;
    case US_MA = 21;
    case US_MI = 22;
    case US_MN = 23;
    case US_MS = 24;
    case US_MO = 25;
    case US_MT = 26;
    case US_NE = 27;
    case US_NV = 28;
    case US_NH = 29;
    case US_NJ = 30;
    case US_NM = 31;
    case US_NY = 32;
    case US_NC = 33;
    case US_ND = 34;
    case US_OH = 35;
    case US_OK = 36;
    case US_OR = 37;
    case US_PA = 38;
    case US_RI = 39;
    case US_SC = 40;
    case US_SD = 41;
    case US_TN = 42;
    case US_TX = 43;
    case US_UT = 44;
    case US_VT = 45;
    case US_VA = 46;
    case US_WA = 47;
    case US_WV = 48;
    case US_WI = 49;
    case US_WY = 50;
    case US_DC = 51;

    case CA_AB = 52;
    case CA_BC = 53;
    case CA_MB = 54;
    case CA_NB = 55;
    case CA_NL = 56;
    case CA_NS = 57;
    case CA_ON = 58;
    case CA_PE = 59;
    case CA_QC = 60;
    case CA_SK = 61;
    case CA_NT = 62;
    case CA_NU = 63;
    case CA_YT = 64;

    public function name(): string
    {
        return match ($this) {
            self::US_AL => 'Alabama',
            self::US_AK => 'Alaska',
            self::US_AZ => 'Arizona',
            self::US_AR => 'Arkansas',
            self::US_CA => 'California',
            self::US_CO => 'Colorado',
            self::US_CT => 'Connecticut',
            self::US_DE => 'Delaware',
            self::US_FL => 'Florida',
            self::US_GA => 'Georgia',
            self::US_HI => 'Hawaii',
            self::US_ID => 'Idaho',
            self::US_IL => 'Illinois',
            self::US_IN => 'Indiana',
            self::US_IA => 'Iowa',
            self::US_KS => 'Kansas',
            self::US_KY => 'Kentucky',
            self::US_LA => 'Louisiana',
            self::US_ME => 'Maine',
            self::US_MD => 'Maryland',
            self::US_MA => 'Massachusetts',
            self::US_MI => 'Michigan',
            self::US_MN => 'Minnesota',
            self::US_MS => 'Mississippi',
            self::US_MO => 'Missouri',
            self::US_MT => 'Montana',
            self::US_NE => 'Nebraska',
            self::US_NV => 'Nevada',
            self::US_NH => 'New Hampshire',
            self::US_NJ => 'New Jersey',
            self::US_NM => 'New Mexico',
            self::US_NY => 'New York',
            self::US_NC => 'North Carolina',
            self::US_ND => 'North Dakota',
            self::US_OH => 'Ohio',
            self::US_OK => 'Oklahoma',
            self::US_OR => 'Oregon',
            self::US_PA => 'Pennsylvania',
            self::US_RI => 'Rhode Island',
            self::US_SC => 'South Carolina',
            self::US_SD => 'South Dakota',
            self::US_TN => 'Tennessee',
            self::US_TX => 'Texas',
            self::US_UT => 'Utah',
            self::US_VT => 'Vermont',
            self::US_VA => 'Virginia',
            self::US_WA => 'Washington',
            self::US_WV => 'West Virginia',
            self::US_WI => 'Wisconsin',
            self::US_WY => 'Wyoming',
            self::US_DC => 'District of Columbia',

            self::CA_AB => 'Alberta',
            self::CA_BC => 'British Columbia',
            self::CA_MB => 'Manitoba',
            self::CA_NB => 'New Brunswick',
            self::CA_NL => 'Newfoundland and Labrador',
            self::CA_NS => 'Nova Scotia',
            self::CA_ON => 'Ontario',
            self::CA_PE => 'Prince Edward Island',
            self::CA_QC => 'Quebec',
            self::CA_SK => 'Saskatchewan',
            self::CA_NT => 'Northwest Territories',
            self::CA_NU => 'Nunavut',
            self::CA_YT => 'Yukon',
        };
    }

}

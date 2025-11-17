<?php

namespace DevFighters\Utils\Domain\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;


class MediumintType extends IntegerType {

    const MEDIUMINT = 'mediumint'; // Nom unique du type

    public function getName():string {
        return self::MEDIUMINT;
    }
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string {
        $return = ($platform->getSmallIntTypeDeclarationSQL($column));
        return ( str_replace ('SMALLINT','MEDIUMINT' ,$return));
    }

    /** Avoid rewriting migrations */
    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return true;
    }

}
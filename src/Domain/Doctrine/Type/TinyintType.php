<?php

namespace DevFighters\Utils\Domain\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;


class TinyintType extends IntegerType {

    const TINYINT = 'tinyint'; // Nom unique du type

    public function getName():string {
        return self::TINYINT;
    }
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string {
        $return = ($platform->getSmallIntTypeDeclarationSQL($column));
        return ( str_replace ('SMALLINT','TINYINT' ,$return));
    }

    /** Avoid rewriting migrations */
    public function requiresSQLCommentHint(AbstractPlatform $platform): true {
        return true;
    }

}
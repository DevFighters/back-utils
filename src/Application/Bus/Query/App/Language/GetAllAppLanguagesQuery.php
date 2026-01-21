<?php

namespace DevFighters\Utils\Application\Bus\Query\App\Language;

use DevFighters\Utils\Application\Bus\Message;
use DevFighters\Utils\Application\Bus\QueryHandler\App\Language\GetAllAppLanguagesQueryHandler;

/**
 * Handler : @see GetAllAppLanguagesQueryHandler
 */
readonly class GetAllAppLanguagesQuery implements Message
{
    public function __construct()
    {
    }
}
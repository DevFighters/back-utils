<?php

namespace DevFighters\Utils\Application\Bus\Query\App\Currency;

use DevFighters\Utils\Application\Bus\Message;
use DevFighters\Utils\Application\Bus\QueryHandler\App\Currency\GetAllAppCurrenciesQueryHandler;

/**
 * Handler : @see GetAllAppCurrenciesQueryHandler
 */
readonly class GetAllAppCurrenciesQuery implements Message
{
    public function __construct()
    {
    }
}
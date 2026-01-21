<?php

namespace DevFighters\Utils\Application\Bus\Query\App\Country;


use DevFighters\Utils\Application\Bus\Message;
use DevFighters\Utils\Application\Bus\QueryHandler\App\Country\GetAllAppCountriesQueryHandler;

/**
 * Handler : @see GetAllAppCountriesQueryHandler
 */
readonly class GetAllAppCountriesQuery implements Message
{
    public function __construct()
    {
    }
}
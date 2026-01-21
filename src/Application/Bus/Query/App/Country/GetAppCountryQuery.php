<?php

namespace DevFighters\Utils\Application\Bus\Query\App\Country;

use DevFighters\Utils\Application\Bus\Message;
use DevFighters\Utils\Application\Bus\QueryHandler\App\Country\GetAppCountryQueryHandler;

/**
 * Handler : @see GetAppCountryQueryHandler
 */
readonly class GetAppCountryQuery implements Message
{
    public function __construct(
        public string $countryId
    )
    {
    }
}
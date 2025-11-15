<?php

namespace DevFighters\Utils\Application\Bus\Query\App\Country;

use DevFighters\Utils\Application\Bus\QueryHandler\App\Country\GetAppCountryQueryHandler;

/**
 * Handler : @see GetAppCountryQueryHandler
 */
readonly class GetAppCountryQuery
{
    public function __construct(
        public string $countryId
    )
    {
    }
}
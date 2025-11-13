<?php

namespace DevFighters\Utils\Application\Bus\Query\App;

use DevFighters\Utils\Application\Bus\QueryHandler\App\GetAppCountryQueryHandler;

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
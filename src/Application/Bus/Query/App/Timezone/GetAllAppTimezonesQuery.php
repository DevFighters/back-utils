<?php

namespace DevFighters\Utils\Application\Bus\Query\App\Timezone;

use DevFighters\Utils\Application\Bus\Message;
use DevFighters\Utils\Application\Bus\QueryHandler\App\Timezone\GetAllAppTimezonesQueryHandler;

/**
 * Handler : @see GetAllAppTimezonesQueryHandler
 */
readonly class GetAllAppTimezonesQuery implements Message
{
    public function __construct()
    {
    }
}
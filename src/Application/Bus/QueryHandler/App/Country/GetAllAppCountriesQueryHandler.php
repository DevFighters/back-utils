<?php

namespace DevFighters\Utils\Application\Bus\QueryHandler\App\Country;

use DevFighters\Utils\Application\Bus\Query\App\Country\GetAllAppCountriesQuery;
use DevFighters\Utils\Domain\Repository\App\AppCountryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetAllAppCountriesQueryHandler
{
    public function __construct(
        private AppCountryRepository $appCountryRepository,
    )
    {
    }

    public function __invoke(GetAllAppCountriesQuery $query): array
    {
        return $this->appCountryRepository->findAll();
    }
}
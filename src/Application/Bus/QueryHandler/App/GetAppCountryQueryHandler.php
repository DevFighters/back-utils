<?php

namespace DevFighters\Utils\Application\Bus\QueryHandler\App;

use DevFighters\Utils\Application\Bus\Query\App\GetAppCountryQuery;
use DevFighters\Utils\Domain\Entity\AppCountry;
use DevFighters\Utils\Domain\Repository\AppCountryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetAppCountryQueryHandler
{
    public function __construct(
        private AppCountryRepository $appCountryRepository,
    )
    {
    }

    public function __invoke(GetAppCountryQuery $query): AppCountry
    {
        return $this->appCountryRepository->find($query->countryId);
    }
}
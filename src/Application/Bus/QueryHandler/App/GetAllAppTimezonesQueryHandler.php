<?php

namespace DevFighters\Utils\Application\Bus\QueryHandler\App;

use DevFighters\Utils\Application\Bus\Query\App\GetAllAppTimezonesQuery;
use DevFighters\Utils\Domain\Repository\App\AppTimezoneRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetAllAppTimezonesQueryHandler
{
    public function __construct(
        private AppTimezoneRepository $appTimezoneRepository,
    )
    {
    }

    public function __invoke(GetAllAppTimezonesQuery $query): array
    {
        return $this->appTimezoneRepository->findAll();
    }
}
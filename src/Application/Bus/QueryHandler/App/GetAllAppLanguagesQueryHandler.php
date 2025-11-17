<?php

namespace DevFighters\Utils\Application\Bus\QueryHandler\App;

use DevFighters\Utils\Application\Bus\Query\App\GetAllAppLanguagesQuery;
use DevFighters\Utils\Domain\Repository\App\AppLanguageRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetAllAppLanguagesQueryHandler
{
    public function __construct(
        private AppLanguageRepository $appTimezoneRepository,
    )
    {
    }

    public function __invoke(GetAllAppLanguagesQuery $query): array
    {
        return $this->appTimezoneRepository->findAll();
    }
}
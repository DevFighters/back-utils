<?php

namespace DevFighters\Utils\Application\Bus\QueryHandler\App;

use DevFighters\Utils\Application\Bus\Query\App\GetAllAppSystemLanguagesQuery;
use DevFighters\Utils\Domain\Repository\AppSystemLanguageRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetAllAppSystemLanguagesQueryHandler
{
    public function __construct(
        private AppSystemLanguageRepository $appLanguageRepository,
    )
    {
    }

    public function __invoke(GetAllAppSystemLanguagesQuery $query): array
    {
        return $this->appLanguageRepository->findAll();
    }
}
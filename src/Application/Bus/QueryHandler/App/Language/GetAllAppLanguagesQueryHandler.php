<?php

namespace DevFighters\Utils\Application\Bus\QueryHandler\App\Language;

use DevFighters\Utils\Application\Bus\Query\App\Language\GetAllAppLanguagesQuery;
use DevFighters\Utils\Domain\Entity\App\AppLanguage;
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
        $languages = $this->appTimezoneRepository->findAll();
        usort($languages,
            static fn(AppLanguage $a, AppLanguage $b) => strcmp($a->getCode(), $b->getCode()));
        return $languages;
    }
}
<?php

namespace DevFighters\Utils\Application\Bus\QueryHandler\App;

use DevFighters\Utils\Application\Bus\Query\App\GetAllAppCurrenciesQuery;
use DevFighters\Utils\Domain\Repository\AppCurrencyRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetAllAppCurrenciesQueryHandler
{
    public function __construct(
        private AppCurrencyRepository $appCurrencyRepository,
    )
    {
    }

    public function __invoke(GetAllAppCurrenciesQuery $query): array
    {
        return $this->appCurrencyRepository->getAll();
    }
}
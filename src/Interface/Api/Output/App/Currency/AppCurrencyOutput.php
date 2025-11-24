<?php

namespace DevFighters\Utils\Interface\Api\Output\App\Currency;

use DevFighters\Utils\Domain\Entity\App\AppCurrency;

readonly class AppCurrencyOutput
{
    public int $id;
    public string $code;

    public function __construct(AppCurrency $currency)
    {
        $this->id = $currency->getId();
        $this->code = $currency->getCode();
    }
}
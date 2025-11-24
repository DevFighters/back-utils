<?php

namespace DevFighters\Utils\Interface\Api\Output\App\Country;

use DevFighters\Utils\Domain\Entity\App\AppCountry;

readonly class AppCountryMiniOutput
{
    public int $id;
    public string $code;
    public string $name;

    public function __construct(AppCountry $country)
    {
        $this->id = $country->getId();
        $this->code = $country->getCode();
        $this->name = $country->getName();
    }
}
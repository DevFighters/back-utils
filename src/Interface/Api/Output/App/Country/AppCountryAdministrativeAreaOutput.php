<?php

namespace DevFighters\Utils\Interface\Api\Output\App\Country;

use DevFighters\Utils\Domain\Entity\App\AppCountryAdministrativeArea;

class AppCountryAdministrativeAreaOutput
{

    public int $id;
    public int $countryId;
    public string $code;
    public string $name;

    public function __construct(AppCountryAdministrativeArea $administrativeArea)
    {
        $this->id = $administrativeArea->getId();
        $this->countryId = $administrativeArea->getCountry()->getId();
        $this->code = $administrativeArea->getCode();
        $this->name = $administrativeArea->getName();
    }
}
<?php

namespace DevFighters\Utils\Application\UseCase\Checker\App;


class AppCountryAdministrativeAreaChecker extends StandardAppChecker
{

    protected function getDatabaseData(): array
    {
        $data = [];
        foreach ($this->entityManager->getRepository($this->dataClass['dataClass'])->findAll() as $elementData) {
            $data[$elementData->getCountry()->getCode()."_".$elementData->getCode()] = $elementData->getId();
        }
        return $data;
    }

}
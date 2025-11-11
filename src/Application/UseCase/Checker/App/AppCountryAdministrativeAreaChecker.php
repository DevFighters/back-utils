<?php

namespace DevFighters\Utils\Application\UseCase\Checker\App;

use DevFighters\Utils\Application\UseCase\Checker\CheckerInterface;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;

class AppCountryAdministrativeAreaChecker extends CheckerInterface
{

    public function __construct(private readonly EntityManagerInterface $entityManager,
                                private readonly array                  $dataClass)
    {
        parent::__construct($dataClass);
    }

    /**
     * @throws ReflectionException
     */
    public function check(): bool
    {
        $referenceData = [];
        foreach ($this->dataClass['enumClass']::cases() as $enumCase) {
            $referenceData[$enumCase->name] = $enumCase->value;
        }
        $databaseData = $this->getDatabaseData();

        $missingInDatabase = array_diff(array_keys($referenceData), array_keys($databaseData));
        $missingInReferenceData = array_diff(array_keys($databaseData), array_keys($referenceData));

        return $this->validateData($missingInDatabase, $missingInReferenceData);
    }

    private function getDatabaseData(): array
    {
        $data = [];
        foreach ($this->entityManager->getRepository($this->dataClass['dataClass'])->findAll() as $elementData) {
            $data[$elementData->getCountry()->getCode()."_".$elementData->getCode()] = $elementData->getId();
        }
        return $data;
    }

}
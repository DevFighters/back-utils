<?php

namespace DevFighters\Utils\Application\UseCase\Checker\App;

use DateTimeZone;
use DevFighters\Utils\Application\UseCase\Checker\CheckerInterface;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;

class AppTimezoneChecker extends CheckerInterface
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
        $referenceData = DateTimeZone::listIdentifiers();
        $databaseData = $this->getDatabaseData();

        $missingInDatabase = array_diff($referenceData, array_keys($databaseData));
        $missingInReferenceData = array_diff(array_keys($databaseData), $referenceData);

        return $this->validateData($missingInDatabase, $missingInReferenceData);
    }

    private function getDatabaseData(): array
    {
        $data = [];
        foreach ($this->entityManager->getRepository($this->dataClass['dataClass'])->findAll() as $elementData) {
            $data[$elementData->getName()] = $elementData->getId();
        }
        return $data;
    }

}
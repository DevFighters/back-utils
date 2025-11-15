<?php

namespace DevFighters\Utils\Application\UseCase\Checker\App;

use DevFighters\Utils\Application\UseCase\Checker\CheckerInterface;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;

class StandardAppChecker extends CheckerInterface
{

    public function __construct(
        protected readonly EntityManagerInterface $entityManager,
        protected readonly array                  $dataClass)
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

    protected function getDatabaseData(): array
    {
        $data = [];
        foreach ($this->entityManager->getRepository($this->dataClass['dataClass'])->findAll() as $elementData) {
            if(property_exists($this->dataClass['dataClass'], 'code')){
                $data[$elementData->getCode()] = $elementData->getId();
            }
            else{
                $data[$elementData->getName()] = $elementData->getId();
            }


        }
        return $data;
    }

}
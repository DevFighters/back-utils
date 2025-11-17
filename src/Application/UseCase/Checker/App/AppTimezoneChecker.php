<?php

namespace DevFighters\Utils\Application\UseCase\Checker\App;

use DateTimeZone;
use ReflectionException;

class AppTimezoneChecker extends StandardAppChecker
{

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

}
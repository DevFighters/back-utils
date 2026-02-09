<?php

namespace DevFighters\Utils\Application\UseCase\Checker;

abstract class CheckerInterface
{
    private array $results = [];
    private array $errorMessages = [];
    private bool $hasErrors = false;

    public function __construct(private readonly array $dataClass)
    {
    }

    public function reset(): void
    {
        $this->results = [];
        $this->errorMessages = [];
        $this->hasErrors = false;
    }

    public function check(): bool
    {
        return true;
    }

    public function getResults(): array
    {
        return $this->results;
    }

    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    public function hasErrors(): bool
    {
        return $this->hasErrors;
    }

    /**
     * @throws \ReflectionException
     */
    protected function validateData(array $missingInDatabase, array $missingInReference): bool
    {
        $isValid = true;

        foreach ($missingInDatabase as $elementData) {
            $this->addError(sprintf('"%s" exists in reference data but missing in database', $elementData));
            $isValid = false;
        }

        foreach ($missingInReference as $referenceData) {
            $this->addError(sprintf('"%s" exists in database but missing in reference data', $referenceData));
            $isValid = false;
        }

        return $isValid;
    }

    /**
     * @throws \ReflectionException
     */
    protected function addError(string $error): void
    {
        $this->errorMessages[] = [$this->getShortName($this->dataClass['dataClass']), $error];
    }

    /**
     * @throws \ReflectionException
     */
    private function getShortName(object|string $target): string
    {
        return new \ReflectionClass($target)->getShortName();
    }
}

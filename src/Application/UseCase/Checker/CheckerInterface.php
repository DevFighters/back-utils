<?php

namespace DevFighters\Utils\Application\UseCase\Checker;

abstract class CheckerInterface
{
    /**
     * @var list<mixed>
     */
    private array $results = [];

    /**
     * @var list<array{0: string, 1: string}>
     */
    private array $errorMessages = [];
    private bool $hasErrors = false;

    /**
     * @param array{dataClass: object|class-string, ...} $dataClass
     */
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

    /**
     * @return list<mixed>
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @return list<array{0: string, 1: string}>
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    public function hasErrors(): bool
    {
        return $this->hasErrors;
    }

    /**
     * @param list<mixed> $missingInDatabase
     * @param list<mixed> $missingInReference
     */
    protected function validateData(array $missingInDatabase, array $missingInReference): bool
    {
        $isValid = true;

        foreach ($missingInDatabase as $elementData) {
            $elementDataAsString = (is_scalar($elementData) || null === $elementData) ? (string) $elementData : get_debug_type($elementData);
            $this->addError(sprintf('"%s" exists in reference data but missing in database', $elementDataAsString));
            $isValid = false;
        }

        foreach ($missingInReference as $referenceData) {
            $referenceDataAsString = (is_scalar($referenceData) || null === $referenceData) ? (string) $referenceData : get_debug_type($referenceData);
            $this->addError(sprintf('"%s" exists in database but missing in reference data', $referenceDataAsString));
            $isValid = false;
        }

        return $isValid;
    }

    protected function addError(string $error): void
    {
        $this->errorMessages[] = [$this->getShortName($this->dataClass['dataClass']), $error];
        $this->hasErrors = true;
    }

    /**
     * @param object|class-string $target
     */
    private function getShortName(object|string $target): string
    {
        return new \ReflectionClass($target)->getShortName();
    }
}

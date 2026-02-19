<?php

namespace DevFighters\Utils\Application\UseCase\Email;

use DevFighters\Utils\Application\UseCase\Checker\CheckerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

readonly class DataChecker
{
    /**
     * @param list<array{checkClass: class-string, dataClass: object|class-string, ...}> $integrityChecks
     */
    public function __construct(private EntityManagerInterface $entityManager,
        private SymfonyStyle $logger,
        private array $integrityChecks = [])
    {
    }

    /**
     * @throws \ReflectionException
     */
    public function executeChecks(): bool
    {
        $success = true;
        foreach ($this->integrityChecks as $integrityCheckData) {
            if (!$this->executeIndividualCheck($integrityCheckData)) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * @param array{checkClass: class-string, dataClass: object|class-string, ...} $integrityCheckData
     *
     * @throws \ReflectionException
     */
    private function executeIndividualCheck(array $integrityCheckData): bool
    {
        /** @var class-string $checkClass */
        $checkClass = $integrityCheckData['checkClass'];
        $checker = new $checkClass($this->entityManager, $integrityCheckData);
        if (!$checker instanceof CheckerInterface) {
            throw new \InvalidArgumentException(sprintf('"%s" must extend %s', $checkClass, CheckerInterface::class));
        }

        $validCheck = $checker->check();

        if ($validCheck) {
            $this->logger->success('Checking '.$this->getShortName($integrityCheckData['dataClass']));
        } else {
            $this->logger->section('Checking '.$this->getShortName($integrityCheckData['dataClass']));
            $this->logger->table(['<fg=red>x Errors</>'], $checker->getErrorMessages());
        }

        return $validCheck;
    }

    /**
     * @throws \ReflectionException
     */
    /**
     * @param object|class-string $target
     */
    private function getShortName(object|string $target): string
    {
        return new \ReflectionClass($target)->getShortName();
    }
}

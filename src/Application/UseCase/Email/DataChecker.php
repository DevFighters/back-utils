<?php

namespace DevFighters\Utils\Application\UseCase\Email;

use DevFighters\Utils\Application\UseCase\Checker\CheckerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

readonly class DataChecker
{
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
     * @throws \ReflectionException
     */
    private function executeIndividualCheck(array $integrityCheckData): bool
    {
        /** @var CheckerInterface $checker */
        $checkClass = $integrityCheckData['checkClass'];
        $checker = new $checkClass($this->entityManager, $integrityCheckData);

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
    private function getShortName(object|string $target): string
    {
        return new \ReflectionClass($target)->getShortName();
    }
}

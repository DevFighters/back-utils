<?php

namespace DevFighters\Utils\Application\Bus;

use Doctrine\ORM\EntityManagerInterface;
use ErrorException;

readonly class TransactionBus
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private HandlerBus             $bus
    ) {}

    public function run(object $command): mixed
    {
        $this->entityManager->beginTransaction();

        try {
            $result = $this->bus->dispatch($command);

            $this->entityManager->flush();
            $this->entityManager->commit();

            return $result;
        }
        catch(ErrorException $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}
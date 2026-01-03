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

    public function run(object $command, bool $withTransaction = true): mixed
    {
        if($withTransaction){
            $this->entityManager->beginTransaction();
        }

        try {
            $result = $this->bus->dispatch($command);
            $this->entityManager->flush();
            if($withTransaction){
                $this->entityManager->commit();
            }

            return $result;
        }
        catch(ErrorException $e) {
            if($withTransaction){
                $this->entityManager->rollback();
            }
            throw $e;
        }
    }
}
<?php

namespace DevFighters\Utils\Application\Bus;

use Doctrine\ORM\EntityManagerInterface;

readonly class TransactionBus
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private HandlerBus $bus,
    ) {
    }

    /**
     * @template TResult
     *
     * @param Message<TResult> $command
     *
     * @return TResult
     */
    public function handle(Message $command, bool $withTransaction = true)
    {
        $inTransaction = false;

        if (
            $withTransaction
            && !$this->entityManager->getConnection()->isTransactionActive()
        ) {
            $this->entityManager->beginTransaction();
            $inTransaction = true;
        }

        try {
            /** @var TResult $result */
            $result = $this->bus->handle($command);

            $this->entityManager->flush();

            if ($inTransaction) {
                $this->entityManager->commit();
            }

            return $result;
        } catch (\Throwable $e) {
            if ($inTransaction) {
                $this->entityManager->rollback();
            }

            throw new \RuntimeException('Transaction failed', previous: $e);
        }
    }
}

<?php

namespace DevFighters\Utils\Application\Bus;

use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

readonly class HandlerBus
{
    public function __construct(
        private MessageBusInterface $messageBus
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function dispatch(mixed $message): mixed
    {
        $envelope = $this->messageBus->dispatch($message);
        return $envelope->last(HandledStamp::class)?->getResult();
    }
}
<?php

namespace DevFighters\Utils\Application\Bus;

use LogicException;
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
     * @template TResult
     * @param Message<TResult> $message
     * @return TResult
     */
    public function handle(Message $message)
    {
        try {
            $envelope = $this->messageBus->dispatch($message);
        } catch (\Throwable $e) {
            throw new \RuntimeException(
                'Message dispatch failed',
                previous: $e
            );
        }

        $stamp = $envelope->last(HandledStamp::class);

        if ($stamp === null) {
            throw new LogicException('Message was not handled');
        }

        return $stamp->getResult();
    }
}
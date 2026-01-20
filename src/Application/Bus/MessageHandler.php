<?php

namespace DevFighters\Utils\Application\Bus;

/**
 * @template TMessage of Message<TResult>
 * @template TResult
 */
interface MessageHandler
{
    /**
     * @param TMessage $message
     * @return TResult
     */
    public function __invoke(Message $message);
}
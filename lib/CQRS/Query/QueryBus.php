<?php

namespace Library\CQRS\Query;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;
use Throwable;

/**
 * Query bus plugged into Symfony Messenger.
 */
class QueryBus
{
    private MessageBusInterface $queryBus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * Dispatches the given query and returns the result.
     *
     * @param StampInterface[] $stamps
     * @throws Throwable
     */
    public function dispatch(QueryInterface|Envelope $query, array $stamps = []): Envelope
    {
        try {
            return $this->queryBus->dispatch($query, $stamps);
        } catch (HandlerFailedException $e) {

            /**
             * Messenger wrap exception thrown in a `HandlerFailedException`, this un-wrap
             * exception and re-throw custom exception to caller.
             * @see https://stackoverflow.com/questions/55558350/custom-exception-from-messenger-handler
             */
            while ($e instanceof HandlerFailedException) {
                $e = $e->getPrevious();
            }

            throw $e;
        }
    }
}

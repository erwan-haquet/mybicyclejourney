<?php

namespace Library\CQRS\Query;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Query bus plugged into Symfony Messenger.
 */
class QueryBus
{
    use HandleTrait;
    
    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * Dispatches the given query and returns the result.
     */
    public function query(QueryInterface|Envelope $query)
    {
        try {
            return $this->handle($query);
        } catch (HandlerFailedException $e) {

            /**
             * Messenger wrap exception thrown in a `HandlerFailedException`, this unwrap
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

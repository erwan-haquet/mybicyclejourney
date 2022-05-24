<?php

namespace Library\CQRS\Query;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;

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
     */
    public function dispatch(QueryInterface|Envelope $query, array $stamps = []): Envelope
    {
        return $this->queryBus->dispatch($query, $stamps);
    }
}

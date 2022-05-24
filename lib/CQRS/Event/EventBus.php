<?php

namespace Library\CQRS\Event;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;

class EventBus
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * Dispatches the given event.
     *
     * @param StampInterface[] $stamps
     */
    public function dispatch(EventInterface|Envelope $event, array $stamps = []): Envelope
    {
        return $this->eventBus->dispatch($event, $stamps);
    }
}

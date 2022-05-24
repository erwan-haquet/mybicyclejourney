<?php

namespace Library\CQRS\Event;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;
use Throwable;

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
     * @throws Throwable
     */
    public function dispatch(EventInterface|Envelope $event, array $stamps = []): Envelope
    {
        try {
            return $this->eventBus->dispatch($event, $stamps);
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

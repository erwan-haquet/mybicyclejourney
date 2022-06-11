<?php

namespace Library\CQRS\Command;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;
use Throwable;

/**
 * Command bus plugged into Symfony Messenger.
 */
class CommandBus
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Dispatches the given command.
     *
     * @param StampInterface[] $stamps
     * @throws Throwable
     */
    public function handle(CommandInterface|Envelope $command, array $stamps = []): Envelope
    {
        try {
            return $this->commandBus->dispatch($command, $stamps);
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

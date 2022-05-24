<?php

namespace Library\CQRS\Command;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;

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
     */
    public function dispatch(CommandInterface|Envelope $command, array $stamps = []): Envelope
    {
        return $this->commandBus->dispatch($command, $stamps);
    }
}

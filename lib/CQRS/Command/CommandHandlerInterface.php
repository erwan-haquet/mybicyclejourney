<?php

namespace Library\CQRS\Command;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * This interface is used to auto-wire command handlers.
 */
interface CommandHandlerInterface extends MessageHandlerInterface
{
}

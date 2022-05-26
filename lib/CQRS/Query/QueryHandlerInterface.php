<?php

namespace Library\CQRS\Query;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * This interface is used to auto-wire query handlers.
 */
interface QueryHandlerInterface extends MessageHandlerInterface
{
}

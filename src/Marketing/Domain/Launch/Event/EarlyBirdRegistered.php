<?php

namespace App\Marketing\Domain\Launch\Event;

use App\Marketing\Domain\Launch\Model\EarlyBird;
use Library\CQRS\Event\EventInterface;

/**
 * A new early bird registered, hourra !
 *
 * @see EarlyBird
 */
class EarlyBirdRegistered implements EventInterface
{
    private int $earlyBirdId;

    public function __construct(int $earlyBirdId)
    {
        $this->earlyBirdId = $earlyBirdId;
    }

    public function getEarlyBirdId(): int
    {
        return $this->earlyBirdId;
    }
}

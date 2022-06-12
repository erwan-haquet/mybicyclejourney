<?php

namespace App\AccountManagement\Domain\User\Event;

use App\AccountManagement\Domain\User\Model\User;
use Library\CQRS\Event\EventInterface;

/**
 * A new user registered, hourra x2 !
 *
 * @see User
 */
class UserRegistered implements EventInterface
{
    private string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}

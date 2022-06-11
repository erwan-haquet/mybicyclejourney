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

    public function __construct(User $user)
    {
        $this->userId = $user->id()->toString();
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}

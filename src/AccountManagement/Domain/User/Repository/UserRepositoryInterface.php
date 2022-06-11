<?php

namespace App\AccountManagement\Domain\User\Repository;

use App\AccountManagement\Domain\User\Exception\EmailIsAlreadyRegistered;
use App\AccountManagement\Domain\User\Exception\UsernameIsAlreadyRegistered;
use App\AccountManagement\Domain\User\Model\User;
use App\AccountManagement\Domain\User\Model\UserId;

interface UserRepositoryInterface
{
    /**
     * Register a new user.
     *
     * @throws EmailIsAlreadyRegistered
     * @throws UsernameIsAlreadyRegistered
     */
    public function register(User $user): void;

    /**
     * Generates a new id.
     */
    public function nextIdentity(): UserId;
}

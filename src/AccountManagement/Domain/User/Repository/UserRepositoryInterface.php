<?php

namespace App\AccountManagement\Domain\User\Repository;

use App\AccountManagement\Domain\User\Exception\EmailIsAlreadyRegisteredException;
use App\AccountManagement\Domain\User\Model\User;
use App\AccountManagement\Domain\User\Model\UserId;

interface UserRepositoryInterface
{
    /**
     * Register a new user.
     *
     * @throws EmailIsAlreadyRegisteredException
     */
    public function register(User $user): void;

    /**
     * Update an existing user.
     */
    public function update(User $user): void;

    /**
     * Finds a user by its id.
     */
    public function findById(UserId $id): ?User;
    
    /**
     * Finds a user by its email.
     */
    public function findByEmail(string $email): ?User;

    /**
     * Generates a new id.
     */
    public function nextIdentity(): UserId;
}

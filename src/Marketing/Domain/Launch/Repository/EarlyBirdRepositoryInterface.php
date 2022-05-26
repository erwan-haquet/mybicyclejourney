<?php

namespace App\Marketing\Domain\Launch\Repository;

use App\Marketing\Domain\Launch\Exception\EmailIsAlreadyRegistered;
use App\Marketing\Domain\Launch\Model\EarlyBird;

interface EarlyBirdRepositoryInterface
{
    /**
     * Adds a new early bird to the repository.
     *
     * @throws EmailIsAlreadyRegistered
     */
    public function add(EarlyBird $earlyBird): void;

    /**
     * Finds an early bird by its id.
     */
    public function findById(int $id): ?EarlyBird;
}

<?php

namespace App\Marketing\Domain\Launch\Repository;

use App\Marketing\Domain\Launch\Model\EarlyBird;

interface EarlyBirdRepositoryInterface
{
    /**
     * Adds a new early bird to the repository.
     */
    public function add(EarlyBird $earlyBird);
}

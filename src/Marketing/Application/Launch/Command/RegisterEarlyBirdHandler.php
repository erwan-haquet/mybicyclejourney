<?php

namespace App\Marketing\Application\Launch\Command;

use App\Marketing\Domain\Launch\Model\EarlyBird;
use App\Marketing\Domain\Launch\Repository\EarlyBirdRepositoryInterface;
use Library\CQRS\Command\CommandHandlerInterface;

class RegisterEarlyBirdHandler implements CommandHandlerInterface
{
    private EarlyBirdRepositoryInterface $repository;

    public function __construct(EarlyBirdRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handleCreateAddress(RegisterEarlyBird $command): void
    {
        $earlyBird = new EarlyBird(
            email: $command->email,
            firstName: $command->firstName,
            lastName: $command->lastName,
        );

        $this->repository->add($earlyBird);
    }
}

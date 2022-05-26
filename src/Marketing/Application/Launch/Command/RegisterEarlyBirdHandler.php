<?php

namespace App\Marketing\Application\Launch\Command;

use App\Marketing\Domain\Launch\Exception\EmailIsAlreadyRegistered;
use App\Marketing\Domain\Launch\Model\EarlyBird;
use App\Marketing\Domain\Launch\Repository\EarlyBirdRepositoryInterface;
use Library\CQRS\Command\CommandHandlerInterface;

class RegisterEarlyBirdHandler implements CommandHandlerInterface
{
    private EarlyBirdRepositoryInterface $repository;

    public function __construct(EarlyBirdRepositoryInterface $repository,)
    {
        $this->repository = $repository;
    }

    /**
     * @throws EmailIsAlreadyRegistered
     */
    public function __invoke(RegisterEarlyBird $command): void
    {
        $earlyBird = new EarlyBird(
            email: $command->email,
            name: $command->name,
        );

        $this->repository->add($earlyBird);
    }
}

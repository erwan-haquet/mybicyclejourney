<?php

namespace App\Marketing\Application\Launch\Command;

use App\Marketing\Domain\Launch\Event\EarlyBirdRegistered;
use App\Marketing\Domain\Launch\Exception\EmailIsAlreadyRegistered;
use App\Marketing\Domain\Launch\Model\EarlyBird;
use App\Marketing\Domain\Launch\Repository\EarlyBirdRepositoryInterface;
use Library\CQRS\Command\CommandHandlerInterface;
use Library\CQRS\Event\EventBus;

class RegisterEarlyBirdHandler implements CommandHandlerInterface
{
    private EarlyBirdRepositoryInterface $repository;
    private EventBus $eventBus;

    public function __construct(
        EarlyBirdRepositoryInterface $repository,
        EventBus                     $eventBus
    )
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
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

        $event = new EarlyBirdRegistered($earlyBird->getId());
        $this->eventBus->dispatch($event);
    }
}

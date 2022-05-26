<?php

namespace App\Marketing\Application\Launch\Event;

use App\Marketing\Domain\Launch\Event\EarlyBirdRegistered;
use App\Marketing\Domain\Launch\Repository\EarlyBirdRepositoryInterface;
use Library\Assert\Assert;
use Library\CQRS\Event\EventHandlerInterface;

class EarlyBirdRegisteredUserNotifier implements EventHandlerInterface
{
    private EarlyBirdRepositoryInterface $repository;

    public function __construct(EarlyBirdRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(EarlyBirdRegistered $event): void
    {
        $earlyBird = $this->repository->findById($event->getEarlyBirdId());
        Assert::notNull($earlyBird, sprintf('No early bird found for id: %s', $earlyBird->getId()));
    }
}

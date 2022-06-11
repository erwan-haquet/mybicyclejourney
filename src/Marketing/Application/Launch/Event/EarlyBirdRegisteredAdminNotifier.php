<?php

namespace App\Marketing\Application\Launch\Event;

use App\Marketing\Domain\Launch\Event\EarlyBirdRegistered;
use App\Marketing\Domain\Launch\Repository\EarlyBirdRepositoryInterface;
use Library\Assert\Assert;
use Library\CQRS\Event\EventHandlerInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

class EarlyBirdRegisteredAdminNotifier implements EventHandlerInterface
{
    private EarlyBirdRepositoryInterface $repository;
    private NotifierInterface $notifier;

    public function __construct(
        EarlyBirdRepositoryInterface $repository,
        NotifierInterface            $notifier,
    )
    {
        $this->repository = $repository;
        $this->notifier = $notifier;
    }

    public function __invoke(EarlyBirdRegistered $event): void
    {
        $earlyBird = $this->repository->findById($event->getEarlyBirdId());
        Assert::notNull($earlyBird, sprintf('No early bird found for id: %s', $event->getEarlyBirdId()));

        $notification = (new Notification('Nouvel early bird', ['email']))
            ->content(sprintf(
                "%s vient de s'inscrire en tant qu'early bird via l'email: %s",
                $earlyBird->getName(),
                $earlyBird->getEmail()
            ));

        foreach ($this->notifier->getAdminRecipients() as $admin) {
            $this->notifier->send($notification, $admin);
        }
    }
}

<?php

namespace App\Marketing\Application\Launch\Event;

use App\Marketing\Domain\Launch\Event\EarlyBirdRegistered;
use App\Marketing\Domain\Launch\Repository\EarlyBirdRepositoryInterface;
use Library\Assert\Assert;
use Library\CQRS\Event\EventHandlerInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class EarlyBirdRegisteredAdminNotifier implements EventHandlerInterface
{
    private EarlyBirdRepositoryInterface $repository;
    private NotifierInterface $notifier;
    private string $adminEmail;

    public function __construct(
        EarlyBirdRepositoryInterface $repository,
        NotifierInterface            $notifier,
        string                       $adminEmail,
    )
    {
        $this->repository = $repository;
        $this->notifier = $notifier;
        $this->adminEmail = $adminEmail;
    }

    public function __invoke(EarlyBirdRegistered $event): void
    {
        $earlyBird = $this->repository->findById($event->getEarlyBirdId());
        Assert::notNull($earlyBird, sprintf('No early bird found for id: %s', $earlyBird->getId()));

        $notification = (new Notification('Nouvel early bird', ['email']))
            ->content(sprintf(
                "%s vient de s'inscrire en tant qu'early bird via l'email: %s",
                $earlyBird->getName(),
                $earlyBird->getEmail()
            ));

        $this->notifier->send($notification, new Recipient($this->adminEmail));
    }
}

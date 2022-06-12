<?php

namespace App\AccountManagement\Application\User\Event;

use App\AccountManagement\Domain\User\Event\UserRegistered;
use App\AccountManagement\Domain\User\Model\UserId;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use Library\Assert\Assert;
use Library\CQRS\Event\EventHandlerInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

class UserRegisteredAdminNotifier implements EventHandlerInterface
{
    private UserRepositoryInterface $repository;
    private NotifierInterface $notifier;

    public function __construct(
        UserRepositoryInterface $repository,
        NotifierInterface       $notifier,
    )
    {
        $this->repository = $repository;
        $this->notifier = $notifier;
    }

    public function __invoke(UserRegistered $event): void
    {
        $id = UserId::fromString($event->getUserId());
        $user = $this->repository->findById($id);

        Assert::notNull($user, sprintf('No user found for id: %s', $id));

        $notification = (new Notification('Nouvel utilisateur', ['email']))
            ->content(sprintf(
                "%s vient de s'inscrire avec l'email: %s",
                $user->username(),
                $user->email()
            ));

        foreach ($this->notifier->getAdminRecipients() as $admin) {
            $this->notifier->send($notification, $admin);
        }
    }
}

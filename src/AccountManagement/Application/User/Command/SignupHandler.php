<?php

namespace App\AccountManagement\Application\User\Command;

use App\AccountManagement\Domain\User\Event\UserRegistered;
use App\AccountManagement\Domain\User\Exception\EmailIsAlreadyRegisteredException;
use App\AccountManagement\Domain\User\Model\User;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use Library\CQRS\Command\CommandHandlerInterface;
use Library\CQRS\Event\EventBus;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignupHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $repository;
    private UserPasswordHasherInterface $passwordHasher;
    private EventBus $eventBus;

    public function __construct(
        UserRepositoryInterface     $repository,
        UserPasswordHasherInterface $passwordHasher,
        EventBus                    $eventBus
    )
    {
        $this->repository = $repository;
        $this->passwordHasher = $passwordHasher;
        $this->eventBus = $eventBus;
    }

    /**
     * @throws EmailIsAlreadyRegisteredException
     */
    public function __invoke(Signup $command): void
    {
        $user = new User(
            id: $command->id,
            email: $command->email,
            locale: $command->locale
        );

        $encodedPassword = $this->passwordHasher->hashPassword($user, $command->plainPassword);
        $user->setPassword($encodedPassword);

        $this->repository->register($user);
        
        $event = new UserRegistered($user->id()->toString());
        $this->eventBus->dispatch($event);
    }
}

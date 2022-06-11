<?php

namespace App\AccountManagement\Application\User\Command;

use App\AccountManagement\Domain\User\Event\UserRegistered;
use App\AccountManagement\Domain\User\Exception\EmailIsAlreadyRegistered;
use App\AccountManagement\Domain\User\Exception\UsernameIsAlreadyRegistered;
use App\AccountManagement\Domain\User\Model\User;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Library\CQRS\Command\CommandHandlerInterface;
use Library\CQRS\Event\EventBus;

class RegisterUserHandler implements CommandHandlerInterface
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
     * @throws EmailIsAlreadyRegistered
     * @throws UsernameIsAlreadyRegistered
     */
    public function __invoke(RegisterUser $command): void
    {
        $user = new User(
            id: $command->id,
            email: $command->email,
            username: $command->username
        );

        $encodedPassword = $this->passwordHasher->hashPassword($user, $command->plainPassword);
        $user->setPassword($encodedPassword);

        $this->repository->register($user);
        
        $event = new UserRegistered($user->id()->toString());
        $this->eventBus->dispatch($event);
    }
}

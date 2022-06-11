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

//        // generate a signed url and email it to the user
//        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//            (new TemplatedEmail())
//                ->from(new Address('erwan@mybicyclejourney.com', 'My Bicycle Journey'))
//                ->to($user->email())
//                ->subject('Please Confirm your Email')
//                ->htmlTemplate('registration/confirmation_email.html.twig')
//        );
//        // do anything else you need here, like send an email
//
        $event = new UserRegistered($user);
        $this->eventBus->dispatch($event);
    }
}

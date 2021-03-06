<?php

namespace App\AccountManagement\Application\User\Command;

use App\AccountManagement\Domain\User\Exception\UserNotFoundException;
use App\AccountManagement\Infrastructure\User\Repository\Doctrine\UserRepository;
use Library\CQRS\Command\CommandHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class ChangePasswordResetHandler implements CommandHandlerInterface
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $userPasswordHasher;
    private ResetPasswordHelperInterface $resetPasswordHelper;

    public function __construct(
        UserRepository               $userRepository,
        UserPasswordHasherInterface  $userPasswordHasher,
        ResetPasswordHelperInterface $resetPasswordHelper
    ) {
        $this->userRepository = $userRepository;
        $this->resetPasswordHelper = $resetPasswordHelper;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @throws UserNotFoundException
     */
    public function __invoke(ChangePassword $command): void
    {
        // Do not reveal whether a user account was found or not.
        if (!$user = $this->userRepository->findById($command->userId)) {
            throw new UserNotFoundException();
        }

        // A password reset token should be used only once, remove it.
        $this->resetPasswordHelper->removeResetRequest($command->token);

        // Encode(hash) the plain password, and set it.
        $encodedPassword = $this->userPasswordHasher->hashPassword(
            $user,
            $command->plainPassword
        );

        $user->setPassword($encodedPassword);
        $this->userRepository->update($user);
    }
}

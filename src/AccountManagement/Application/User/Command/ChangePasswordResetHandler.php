<?php

namespace App\AccountManagement\Application\User\Command;

use App\AccountManagement\Domain\User\Exception\UserNotFound;
use App\AccountManagement\Infrastructure\User\Repository\Doctrine\UserRepository;
use Library\CQRS\Command\CommandHandlerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class ChangePasswordResetHandler implements CommandHandlerInterface
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $userPasswordHasher;
    private ResetPasswordHelperInterface $resetPasswordHelper;
    private RequestStack $requestStack;

    public function __construct(
        UserRepository               $userRepository,
        UserPasswordHasherInterface  $userPasswordHasher,
        ResetPasswordHelperInterface $resetPasswordHelper,
        RequestStack                 $requestStack,
    ) {
        $this->userRepository = $userRepository;
        $this->resetPasswordHelper = $resetPasswordHelper;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->requestStack = $requestStack;
    }

    /**
     * @throws UserNotFound
     */
    public function __invoke(ChangePassword $command): void
    {
        // Do not reveal whether a user account was found or not.
        if (!$user = $this->userRepository->findById($command->userId)) {
            throw new UserNotFound();
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

        // The session is cleaned up after the password has been changed.
        $session = $this->requestStack->getSession();
        $session->remove('ResetPasswordPublicToken');
        $session->remove('ResetPasswordCheckEmail');
        $session->remove('ResetPasswordToken');
    }
}

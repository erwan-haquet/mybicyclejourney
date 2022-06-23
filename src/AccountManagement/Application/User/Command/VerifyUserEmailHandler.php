<?php

namespace App\AccountManagement\Application\User\Command;

use App\AccountManagement\Domain\User\Exception\CannotVerifyUserEmailException;
use App\AccountManagement\Domain\User\Exception\UserNotFoundException;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use Library\CQRS\Command\CommandHandlerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class VerifyUserEmailHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $repository;
    private VerifyEmailHelperInterface $verifyEmailHelper;

    public function __construct(
        UserRepositoryInterface    $repository,
        VerifyEmailHelperInterface $verifyEmailHelper
    )
    {
        $this->repository = $repository;
        $this->verifyEmailHelper = $verifyEmailHelper;
    }

    /**
     * @throws CannotVerifyUserEmailException
     * @throws UserNotFoundException
     */
    public function __invoke(VerifyUserEmail $command): void
    {
        if (!$user = $this->repository->findById($command->id)) {
            throw new UserNotFoundException();
        }

        try {
            $this->verifyEmailHelper->validateEmailConfirmation(
                $command->uri,
                $user->email(),
                $user->email()
            );
        } catch (VerifyEmailExceptionInterface $exception) {
            throw new CannotVerifyUserEmailException($exception->getReason());
        }

        $user->verify();
        
        $this->repository->update($user);
    }
}

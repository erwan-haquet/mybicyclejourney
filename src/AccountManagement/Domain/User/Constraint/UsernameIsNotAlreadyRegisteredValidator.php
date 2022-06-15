<?php

namespace App\AccountManagement\Domain\User\Constraint;

use App\AccountManagement\Application\User\Command\Signup;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UsernameIsNotAlreadyRegisteredValidator extends ConstraintValidator
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository  = $repository;
    }

    public function validate($command, Constraint $constraint): void
    {
        if (!$constraint instanceof UsernameIsNotAlreadyRegistered) {
            throw new UnexpectedTypeException($constraint, UsernameIsNotAlreadyRegistered::class);
        }

        if (null === $command || '' === $command) {
            return;
        }

        if (!$command instanceof Signup) {
            throw new UnexpectedValueException($command, Signup::class);
        }

        if (null === $command->username) {
            return;
        }
        
        if (null === $this->repository->findByUsername($command->username)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->atPath('username')
            ->addViolation();
    }
}

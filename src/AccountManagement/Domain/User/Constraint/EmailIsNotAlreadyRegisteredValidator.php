<?php

namespace App\AccountManagement\Domain\User\Constraint;

use App\AccountManagement\Application\User\Command\RegisterUser;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class EmailIsNotAlreadyRegisteredValidator extends ConstraintValidator
{
    private UserRepositoryInterface $repository;
    
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository  = $repository;
    }
    
    public function validate($command, Constraint $constraint): void
    {
        if (!$constraint instanceof EmailIsNotAlreadyRegistered) {
            throw new UnexpectedTypeException($constraint, EmailIsNotAlreadyRegistered::class);
        }

        if (null === $command || '' === $command) {
            return;
        }

        if (!$command instanceof RegisterUser) {
            throw new UnexpectedValueException($command, RegisterUser::class);
        }
        
        if (null === $command->email) {
            return;
        }
        
        if (null === $this->repository->findByEmail($command->email)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->atPath('email')
            ->addViolation();
    }
}

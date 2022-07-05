<?php

namespace App\AccountManagement\Domain\User\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EmailIsNotAlreadyRegistered extends Constraint
{
    public $message = 'user.signup.email_already_exists';

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}

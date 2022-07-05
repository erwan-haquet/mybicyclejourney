<?php

namespace App\AccountManagement\Application\User\Command;

use Library\CQRS\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Request a password reset.
 */
class RequestPasswordReset extends Command
{
    /**
     * @Assert\NotBlank(message="user.password_reset.email_is_blank")
     */
    public ?string $email;
}

<?php

namespace App\AccountManagement\Application\User\Command;

use App\AccountManagement\Domain\User\Model\UserId;
use Library\CQRS\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reset a password.
 */
class ChangePassword extends Command
{
    public UserId $userId;
    
    public ?string $token;
    
    /**
     *  4096 is the max length allowed by Symfony for security reasons.
     *
     * @Assert\NotBlank(message="account_management.signup.password_is_blank")
     * @Assert\Length(
     *     min=8,
     *     minMessage="account_management.signup.password_is_too_small",
     *     max=4096
     * )
     * @Assert\Regex(
     *     pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/",
     *     message="account_management.signup.password_is_invalid"
     * )
     */
    public ?string $plainPassword;
}

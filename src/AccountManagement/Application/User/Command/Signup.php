<?php

namespace App\AccountManagement\Application\User\Command;

use App\AccountManagement\Domain\User\Constraint as CustomAssert;
use App\AccountManagement\Domain\User\Model\User;
use App\AccountManagement\Domain\User\Model\UserId;
use App\Supporting\Domain\I18n\Model\Locale;
use Library\CQRS\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Register a new user.
 *
 * @see User
 * @CustomAssert\EmailIsNotAlreadyRegistered
 */
class Signup extends Command
{
    public UserId $id;

    public Locale $locale;

    /**
     * @Assert\NotBlank(message="account_management.signup.email_is_blank")
     * @Assert\Email(message="account_management.signup.email_is_invalid")
     */
    public ?string $email = null;

    /**
     *  4096 is the max length allowed by Symfony for security reasons.
     *
     * @Assert\NotBlank(message="account_management.signup.password_is_blank")
     * @Assert\Length(
     *     min=6,
     *     minMessage="account_management.signup.password_is_too_small",
     *     max=4096
     * )
     * @Assert\Regex(
     *     pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/",
     *     message="account_management.signup.password_is_invalid"
     * )
     */
    public ?string $plainPassword = null;
}

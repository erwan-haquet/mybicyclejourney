<?php

namespace App\AccountManagement\Application\User\Command;

use App\AccountManagement\Domain\User\Model\User;
use App\AccountManagement\Domain\User\Model\UserId;
use App\Supporting\Domain\I18n\Model\Locale;
use Library\CQRS\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;
use App\AccountManagement\Domain\User\Constraint as CustomAssert;

/**
 * Register a new user.
 *
 * @see User
 * @CustomAssert\EmailIsNotAlreadyRegistered
 * @CustomAssert\UsernameIsNotAlreadyRegistered
 */
class RegisterUser extends Command
{
    public UserId $id;

    public Locale $locale;

    /**
     * @Assert\NotBlank(message="account_management.register_user.email_is_blank")
     * @Assert\Email(message="account_management.register_user.email_is_invalid")
     */
    public ?string $email = null;

    /**
     * @Assert\NotBlank(message="account_management.register_user.username_is_blank")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9]*$/",
     *     message="account_management.register_user.username_is_invalid"
     * )
     */
    public ?string $username = null;

    /**
     *  4096 is the max length allowed by Symfony for security reasons.
     *
     * @Assert\NotBlank(message="account_management.register_user.password_is_blank")
     * @Assert\Length(
     *     min=8,
     *     minMessage="account_management.register_user.password_is_too_small",
     *     max=4096
     * )
     * @Assert\Regex(
     *     pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/",
     *     message="account_management.register_user.password_is_invalid"
     * )
     */
    public ?string $plainPassword = null;

    /**
     * @Assert\IsTrue(message="account_management.register_user.not_agreed_terms")
     */
    public ?bool $agreeTerms = null;
}

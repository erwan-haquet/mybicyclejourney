<?php

namespace App\AccountManagement\Application\User\Command;

use App\AccountManagement\Domain\User\Model\UserId;
use App\Marketing\Domain\Launch\Model\EarlyBird;
use Library\CQRS\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Register a new user.
 *
 * @see EarlyBird
 */
class RegisterUser extends Command
{
    public UserId $id;

    /**
     * @Assert\NotBlank(message="account_management.register_user.email_is_blank")
     * @Assert\Email(message="account_management.register_user.email_is_invalid")
     */
    public ?string $email = null;

    /**
     * @Assert\NotBlank(message="account_management.register_user.username_is_blank")
     */
    public ?string $username = null;

    /**
     *  4096 is the max length allowed by Symfony for security reasons.
     *
     * @Assert\NotBlank(message="account_management.register_user.password_is_blank")
     * @Assert\Length(
     *     min=6,
     *     minMessage="account_management.register_user.password_is_too_small",
     *     max=4096
     * )
     */
    public ?string $plainPassword = null;

    /**
     * @Assert\IsTrue(message="account_management.register_user.not_agreed_terms")
     */
    public ?bool $agreeTerms = null;
}

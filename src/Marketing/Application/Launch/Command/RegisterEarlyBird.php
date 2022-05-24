<?php

namespace App\Marketing\Application\Launch\Command;

use App\Marketing\Domain\Launch\Model\EarlyBird;
use Library\CQRS\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Register a new early bird.
 * @see EarlyBird
 */
class RegisterEarlyBird extends Command
{
    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    public ?string $email = null;

    public ?string $firstName = null;

    public ?string $lastName = null;
}

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
     * @Assert\NotBlank(message="On ne pourra pas t'envoyer d'email sans ton adresse :/")
     * @Assert\Email(message="On ne pourra pas t'envoyer d'email sur cette adresse :/")
     */
    public ?string $email = null;

    /**
     * @Assert\NotBlank(message="C'est plus sympa si on peut s'appeler par nos prénoms non ?")
     */
    public ?string $name = null;
}

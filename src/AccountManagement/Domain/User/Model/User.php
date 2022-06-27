<?php

namespace App\AccountManagement\Domain\User\Model;

use App\Supporting\Domain\I18n\Model\Locale;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The base user account, used for security.
 */
#[ORM\Entity]
#[ORM\Table(name: 'account_management_user')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $username;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private ?string $password;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

    #[ORM\Embedded(class: Locale::class)]
    private Locale $locale;

    public function __construct(
        UserId $id,
        string $email,
        string $username,
        Locale $locale,
    )
    {
        $this->id = $id->toString();
        $this->email = $email;
        $this->username = $username;
        $this->locale = $locale;
    }

    public function id(): UserId
    {
        return UserId::fromString($this->id);
    }

    public function email(): string
    {
        return $this->email;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function locale(): Locale
    {
        return $this->locale;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $encodedPassword): self
    {
        $this->password = $encodedPassword;
        return $this;
    }
    
    public function isVerified(): bool
    {
        return $this->isVerified;
    }
    
    public function verify(): self
    {
        $this->isVerified = true;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}

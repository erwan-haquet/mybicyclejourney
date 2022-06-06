<?php

namespace App\Marketing\Domain\Launch\Model;

use App\Supporting\Domain\I18n\Model\Locale;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Early birds are people who registered early on the "under construction" website.
 * They registered to be kept in touch and received early communications.
 */
#[ORM\Entity]
#[UniqueEntity("email")]
#[ORM\Table(name: "marketing_early_bird")]
class EarlyBird
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id;

    #[ORM\Column(type: "string", unique: true)]
    private string $email;

    #[ORM\Column(type: "string")]
    private string $name;

    #[ORM\Embedded(class: Locale::class)]
    private Locale $locale;

    public function __construct(string $email, string $name, ?Locale $locale)
    {
        $this->email = $email;
        $this->name = $name;
        $this->locale = $locale ?? Locale::from('en');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }
    
    public function getLocale(): Locale
    {
        return $this->locale;
    }
}

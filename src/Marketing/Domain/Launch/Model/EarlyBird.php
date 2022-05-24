<?php

namespace App\Marketing\Domain\Launch\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Early birds are people who registered early on the "under construction" website.
 * They registered to be kept in touch and received early communications.
 *
 * @ORM\Entity
 * @ORM\Table(name="marketing_early_bird")
 */
class EarlyBird
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    public function __construct(string $email, string $name)
    {
        $this->email = $email;
        $this->name = $name;
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
}

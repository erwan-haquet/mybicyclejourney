<?php

namespace App\Supporting\Domain\Entity\Model;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Library\Assert\Assert;

/**
 * @ORM\Embeddable
 */
abstract class Uuid implements JsonSerializable
{
    /**
     * @ORM\Column(type="uuid")
     */
    protected string $value;

    final protected function __construct(string $id)
    {
        Assert::uuid($id);
        $this->value = $id;
    }

    public static function fromString(string $id): static
    {
        return new static($id);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }

    public function equals(?Uuid $other): bool
    {
        if (null === $other) {
            return false;
        }

        return $other->value === $this->value;
    }
}

<?php

namespace App\ContentManagement\Domain\Website\Model\Page;

use Doctrine\ORM\Mapping as ORM;

/**
 * The relative url path to the page.
 */
#[ORM\Embeddable]
class Path
{
    #[ORM\Column(type: 'string')]
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
    
    public static function new(string $value): Path
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

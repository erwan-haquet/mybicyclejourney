<?php

namespace App\ContentManagement\Domain\Website\Model\Page;

use Doctrine\ORM\Mapping as ORM;

/**
 * The title tag defines the title of the document. 
 * 
 * The title must be text-only, and it is shown in 
 * the browser's title bar or in the page's tab.
 */
#[ORM\Embeddable]
class Title
{
    #[ORM\Column(type: 'string')]
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * According to some research on popular websites,
     * the title length is roughly always between 40 & 80 characters.
     */
    public static function new(string $value): Title
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

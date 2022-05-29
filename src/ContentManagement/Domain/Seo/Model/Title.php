<?php

namespace App\ContentManagement\Domain\Seo\Model;

use Library\Assert\Assert;

/**
 * The title tag defines the title of the document. The title must be text-only, 
 * and it is shown in the browser's title bar or in the page's tab.
 */
class Title
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function new(string $value): Title
    {
        // According to some research on popular websites, 
        // the title length is always between 50 & 80 characters.
        Assert::lengthBetween($value, 50, 80);
        
        return new self($value);
    }
    
    public function __toString(): string
    {
        return $this->value;
    }
}

<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

/**
 * The name of the document's author.
 */
class Author extends MetaName 
{
    private const PROPERTY = 'author';

    public static function new(string $content): Author
    {
        return new self(self::PROPERTY, $content);
    }
}

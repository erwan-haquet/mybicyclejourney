<?php

namespace App\ContentManagement\Domain\Seo\Model\MetaName;

/**
 * The name of the document's author.
 */
class Author extends Meta
{
    private const PROPERTY = 'author';

    public static function new(string $content): Author
    {
        return new self(self::PROPERTY, $content);
    }
}

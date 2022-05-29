<?php

namespace App\ContentManagement\Domain\Seo\Model\MetaName;

/**
 * A short and accurate summary of the content of the page. 
 * Several browsers, like Firefox and Opera, use this as the default description of bookmarked pages.
 */
class Description extends Meta
{
    private const PROPERTY = 'description';

    public static function new(string $content): Description
    {
        return new self(self::PROPERTY, $content);
    }
}

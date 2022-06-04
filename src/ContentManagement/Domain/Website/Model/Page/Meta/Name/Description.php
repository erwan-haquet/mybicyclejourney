<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

/**
 * A short and accurate summary of the content of the page.
 * Several browsers, like Firefox and Opera, use this as the default description of bookmarked pages.
 */
class Description extends MetaName 
{
    private const PROPERTY = 'description';

    /**
     * The recommended meta description length is 920 pixels
     * or roughly 155 characters or fewer including spaces
     */
    public static function new(string $content): Description
    {
        return new self(self::PROPERTY, $content);
    }
}

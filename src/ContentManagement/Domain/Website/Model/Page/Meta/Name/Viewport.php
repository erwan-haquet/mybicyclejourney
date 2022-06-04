<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

/**
 * The browser's viewport is the area of the window in which web content 
 * can be seen. This is often not the same size as the rendered page, 
 * in which case the browser provides scrollbars for the user to scroll 
 * around and access all the content.
 */
class Viewport extends MetaName
{
    public const NAME = 'viewport';

    public static function new(string $content): Viewport
    {
        return new self(self::NAME, $content);
    }
}

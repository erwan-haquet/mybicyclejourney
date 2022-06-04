<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

/**
 * The identifier of the software that generated the page.
 */
class Generator extends MetaName
{
    private const PROPERTY = 'generator';

    public static function new(string $content): Generator
    {
        return new self(self::PROPERTY, $content);
    }
}
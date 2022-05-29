<?php

namespace App\ContentManagement\Domain\Seo\Model\MetaName;

/**
 * The identifier of the software that generated the page.
 */
class Generator extends Meta
{
    private const PROPERTY = 'generator';

    public static function new(string $content): Generator
    {
        return new self(self::PROPERTY, $content);
    }
}

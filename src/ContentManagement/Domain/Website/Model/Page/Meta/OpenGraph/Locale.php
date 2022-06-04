<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

/**
 * The locale these tags are marked up in. Of the format language_TERRITORY. 
 * Default is en_US.
 */
class Locale extends OpenGraph
{
    private const PROPERTY = 'locale';

    public static function new(string $content): Locale
    {
        return new self(self::PROPERTY, $content);
    }
}

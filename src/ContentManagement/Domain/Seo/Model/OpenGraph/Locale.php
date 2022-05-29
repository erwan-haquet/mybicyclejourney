<?php

namespace App\ContentManagement\Domain\Seo\Model\OpenGraph;

/**
 * The locale these tags are marked up in. Of the format language_TERRITORY. 
 * Default is en_US.
 */
class Locale extends Meta
{
    private const PROPERTY = 'locale';

    public static function new(string $content): Locale
    {
        return new self(self::PROPERTY, $content);
    }
}

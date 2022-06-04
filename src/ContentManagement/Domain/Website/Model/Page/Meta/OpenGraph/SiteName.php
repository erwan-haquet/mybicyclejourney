<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

/**
 * If your object is part of a larger website, 
 * the name which should be displayed for the overall site. e.g., "IMDb".
 */
class SiteName extends OpenGraph
{
    private const PROPERTY = 'site_name';

    public static function new(string $content): SiteName
    {
        return new self(self::PROPERTY, $content);
    }
}

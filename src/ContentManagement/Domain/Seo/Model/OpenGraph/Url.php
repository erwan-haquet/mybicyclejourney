<?php

namespace App\ContentManagement\Domain\Seo\Model\OpenGraph;

/**
 * The canonical URL of your object that will be used as its 
 * permanent ID in the graph, e.g., "https://www.imdb.com/title/tt0117500/".
 */
class Url extends Meta
{
    private const PROPERTY = 'url';

    public static function new(string $content): Url
    {
        return new self(self::PROPERTY, $content);
    }
}

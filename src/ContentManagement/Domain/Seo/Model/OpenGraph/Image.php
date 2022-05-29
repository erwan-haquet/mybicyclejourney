<?php

namespace App\ContentManagement\Domain\Seo\Model\OpenGraph;

/**
 * An image URL which should represent your object within the graph.
 */
class Image extends Meta
{
    private const PROPERTY = 'image';

    public static function new(string $content): Image
    {
        return new self(self::PROPERTY, $content);
    }
}

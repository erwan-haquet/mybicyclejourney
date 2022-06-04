<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

/**
 * An image URL which should represent your object within the graph.
 */
class Image extends OpenGraph
{
    private const PROPERTY = 'image';

    /**
     * Image recommandation is 1200x630px with a maximum of 1MB.
     */
    public static function new(string $content): Image
    {
        return new self(self::PROPERTY, $content);
    }
}

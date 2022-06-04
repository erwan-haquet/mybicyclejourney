<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

/**
 * The title of your object as it should appear within the graph, e.g., "The Rock".
 */
class Title extends OpenGraph
{
    private const PROPERTY = 'title';

    public static function new(string $content): Title
    {
        return new self(self::PROPERTY, $content);
    }
}

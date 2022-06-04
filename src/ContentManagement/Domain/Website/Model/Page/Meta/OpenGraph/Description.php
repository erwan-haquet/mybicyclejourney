<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

/**
 * A one to two sentence description of your object.
 */
class Description extends OpenGraph
{
    private const PROPERTY = 'description';

    /**
     * SEO experts recommend that you do not go beyond the limit of 200 characters.
     */
    public static function new(string $content): Description
    {
        return new self(self::PROPERTY, $content);
    }
}

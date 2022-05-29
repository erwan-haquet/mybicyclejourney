<?php

namespace App\ContentManagement\Domain\Seo\Model\OpenGraph;

/**
 * A one to two sentence description of your object.
 */
class Description extends Meta
{
    private const PROPERTY = 'description';

    public static function new(string $content): Description
    {
        return new self(self::PROPERTY, $content);
    }
}

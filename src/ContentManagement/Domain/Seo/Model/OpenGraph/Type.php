<?php

namespace App\ContentManagement\Domain\Seo\Model\OpenGraph;

/**
 * The type of your object, e.g., "video.movie". 
 * Depending on the type you specify, other properties may also be required.
 * 
 * @see https://ogp.me/#types
 */
class Type extends Meta
{
    private const PROPERTY = 'type';

    public static function new(string $content): Type
    {
        return new self(self::PROPERTY, $content);
    }
}

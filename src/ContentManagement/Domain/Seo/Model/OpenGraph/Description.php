<?php

namespace App\ContentManagement\Domain\Seo\Model\OpenGraph;

use Library\Assert\Assert;

/**
 * A one to two sentence description of your object.
 */
class Description extends Meta
{
    private const PROPERTY = 'description';

    public static function new(string $content): Description
    {
        // The recommended meta description length is 920 pixels
        // or roughly 155 characters or less including spaces 
        Assert::maxLength($content, 160);

        return new self(self::PROPERTY, $content);
    }
}

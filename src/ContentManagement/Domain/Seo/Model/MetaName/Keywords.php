<?php

namespace App\ContentManagement\Domain\Seo\Model\MetaName;

/**
 * Words relevant to the page's content separated by commas.
 */
class Keywords extends Meta
{
    private const PROPERTY = 'keywords';

    public static function new(iterable $values): Keywords
    {
        return new self(self::PROPERTY, implode(', ', $values));
    }
}

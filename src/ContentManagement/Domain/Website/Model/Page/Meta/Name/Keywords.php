<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

/**
 * Words relevant to the page's content separated by commas.
 */
class Keywords extends MetaName
{
    private const PROPERTY = 'keywords';

    public static function new(iterable $values): Keywords
    {
        return new self(self::PROPERTY, implode(', ', $values));
    }
}

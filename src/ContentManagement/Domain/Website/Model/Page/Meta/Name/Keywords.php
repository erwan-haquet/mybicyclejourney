<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

/**
 * Words relevant to the page's content separated by commas.
 */
class Keywords extends MetaName
{
    public const NAME = 'keywords';

    public static function new(array $values): Keywords
    {
        return new self(self::NAME, implode(', ', $values));
    }
}

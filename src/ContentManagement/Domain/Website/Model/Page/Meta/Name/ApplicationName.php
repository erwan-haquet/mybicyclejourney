<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

/**
 * The name of the application running in the web page.
 */
class ApplicationName extends MetaName
{
    private const PROPERTY = 'application-name';

    public static function new(string $content): ApplicationName
    {
        return new self(self::PROPERTY, $content);
    }
}

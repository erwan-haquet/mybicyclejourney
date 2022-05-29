<?php

namespace App\ContentManagement\Domain\Seo\Model\MetaName;

/**
 * The name of the application running in the web page.
 */
class ApplicationName extends Meta
{
    private const PROPERTY = 'application-name';

    public static function new(string $content): ApplicationName
    {
        return new self(self::PROPERTY, $content);
    }
}

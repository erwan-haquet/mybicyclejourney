<?php

namespace App\ContentManagement\Domain\Seo\Model\MetaName;

use Library\Assert\Assert;

/**
 * The behavior that cooperative crawlers, or "robots", should use with the page.
 * It is a comma-separated list of the values below.
 */
class Robots extends Meta
{
    private const PROPERTY = 'robots';

    public static function new(array $values): Robots
    {
        Assert::allIsAnyOf($values, self::availableValues());

        return new self(self::PROPERTY, implode(', ', $values));
    }

    private static function availableValues(): array
    {
        return [
            // Allows the robot to index the page (default).
            // Used by: All
            'index',

            // Requests the robot to not index the page.
            // Used by: All
            'noindex',

            // Allows the robot to follow the links on the page (default).
            // Used by: All
            'follow',

            // Requests the robot to not follow the links on the page.
            // Used by: All
            'nofollow',

            // Equivalent to index, follow
            // Used by: Google
            'all',

            // Equivalent to noindex, nofollow
            // Used by: Google
            'none',

            // Requests the search engine not to cache the page content.
            // Used by: Google, Yahoo, Bing
            'noarchive',

            // Prevents displaying any description of the page in search engine results.
            // Used by: Google, Bing
            'nosnippet',

            // Requests this page not to appear as the referring page of an indexed image.
            // Used by: Google
            'noimageindex',

            // Synonym of noarchive.
            // Used by: Bing
            'nocache',
        ];
    }
}

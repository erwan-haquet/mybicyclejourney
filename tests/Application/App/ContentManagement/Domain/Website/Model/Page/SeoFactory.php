<?php

namespace Tests\Application\App\ContentManagement\Domain\Website\Model\Page;

use App\ContentManagement\Domain\Website\Model\Page\Seo;

class SeoFactory
{
    public static function new(
        ?float $crawlPriority = null,
        ?bool $shouldIndex = true,
    ): Seo {
        return new Seo(
            crawlPriority: $crawlPriority,
            shouldIndex: $shouldIndex,
        );
    }
}

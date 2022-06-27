<?php

namespace App\ContentManagement\Ui\Static\Web\Dto\Sitemap;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use Library\Assert\Assert;
use Library\Utils\View;

class SitemapDto extends View
{
    public array $urls = [];

    /**
     * Build the sitemap with given pages.
     */
    public static function new(array $pages): self
    {
        Assert::allIsInstanceOf($pages, Page::class);
        
        $sitemap = new self();
        foreach ($pages as $page) {
            $sitemap->urls[] = UrlDto::fromPage($page);
        }

        return $sitemap;
    }
}

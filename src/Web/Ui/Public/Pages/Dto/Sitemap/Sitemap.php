<?php

namespace App\Web\Ui\Public\Pages\Dto\Sitemap;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use Library\Assert\Assert;
use Library\Utils\View;

class Sitemap extends View
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
            $sitemap->urls[] = Url::fromPage($page);
        }

        return $sitemap;
    }
}

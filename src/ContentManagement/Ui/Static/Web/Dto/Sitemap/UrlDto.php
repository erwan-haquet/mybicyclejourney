<?php

namespace App\ContentManagement\Ui\Static\Web\Dto\Sitemap;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use Library\Utils\View;

class UrlDto extends View
{
    public string $loc;

    public string $lastmod;

    public float $priority;

    public static function fromPage(Page $page): static
    {
        return new self([
            'loc' => $page->url(),
            'lastmod' => $page->updatedAt()->format("Y-m-d"),
            'priority' => $page->crawlPriority(),
        ]);
    }
}

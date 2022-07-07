<?php

namespace App\ContentManagement\Ui\Frontend\Pages\View\Sitemap;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use Library\Utils\View;

class Url extends View
{
    public string $loc;
    
    public float $priority;

    public static function fromPage(Page $page): self
    {
        return new self([
            'loc' => $page->url(),
            'priority' => $page->crawlPriority(),
        ]);
    }
}

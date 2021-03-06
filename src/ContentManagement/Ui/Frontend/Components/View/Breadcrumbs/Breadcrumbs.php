<?php

namespace App\ContentManagement\Ui\Frontend\Components\View\Breadcrumbs;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use Library\Utils\View;

class Breadcrumbs extends View
{
    public array $items = [];

    /**
     * Build the breadcrumbs for the given page.
     */
    public static function new(Page $page): self
    {
        $cursor = $page;
        $items = [];
        while (null !== $cursor) {
            $item = new Item([
                'label' => $cursor->label(),
                'url' => $cursor->url(),
            ]);

            // Add the page at the beginning to keep thing sorted properly
            array_unshift($items, $item);
            $cursor = $cursor->parent();
        }

        return new self([
            'items' => $items
        ]);
    }
}

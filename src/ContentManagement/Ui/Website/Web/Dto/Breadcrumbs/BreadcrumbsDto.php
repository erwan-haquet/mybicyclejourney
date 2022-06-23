<?php

namespace App\ContentManagement\Ui\Website\Web\Dto\Breadcrumbs;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use Library\Utils\View;

class BreadcrumbsDto extends View
{
    public array $items = [];

    /**
     * Build the breadcrumbs for the given page.
     */
    public static function new(Page $page): static
    {
        $cursor = $page;
        $items = [];
        while (null !== $cursor) {
            $item = new ItemDto([
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

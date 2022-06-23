<?php

namespace App\ContentManagement\Ui\Website\Web\Dto\Breadcrumbs;

use Library\Utils\View;

class ItemDto extends View
{
    /**
     * The label displayed to the user.
     */
    public string $label;
    
    public string $url;
}

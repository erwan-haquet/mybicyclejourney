<?php

namespace App\ContentManagement\Ui\Frontend\Components\View\Breadcrumbs;

use Library\Utils\View;

class Item extends View
{
    /**
     * The label displayed to the user.
     */
    public string $label;
    
    public string $url;
}

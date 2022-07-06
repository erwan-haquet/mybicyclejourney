<?php

namespace App\Web\Ui\Shared\Layout\Dto\Breadcrumbs;

use Library\Utils\View;

class Item extends View
{
    /**
     * The label displayed to the user.
     */
    public string $label;
    
    public string $url;
}

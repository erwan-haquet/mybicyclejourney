<?php

namespace App\ContentManagement\Ui\Dashboard\Components\View\Navbar;

use Library\Utils\View;

/**
 * Router data required to switch locale from navbar.
 */
class LocaleSwitcher extends View
{
    /**
     * The current route name.
     */
    public string $route;

    /**
     * An array of current query params.
     */
    public array $queryParams;
}

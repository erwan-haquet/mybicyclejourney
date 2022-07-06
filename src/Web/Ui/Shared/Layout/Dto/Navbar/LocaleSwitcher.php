<?php

namespace App\Web\Ui\Shared\Layout\Dto\Navbar;

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

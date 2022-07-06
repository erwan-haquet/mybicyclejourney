<?php

namespace App\Web\Ui\Public\Layout\Dto\Navbar;

use Library\Utils\View;

/**
 * Router data required to switch locale from navbar.
 */
class LocaleSwitcherDto extends View
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

<?php

namespace App\ContentManagement\Application\Components\Query;

use App\ContentManagement\Ui\Components\Web\Dto\Navbar\NavbarDto;
use Library\CQRS\Query\Query;

/**
 * Build the navbar.
 *
 * @see NavbarDto
 */
class BuildNavbar extends Query
{
    /**
     * The current request route name.
     */
    public string $route;
    
    /**
     * The current request query params.
     */
    public array $queryParams;
}

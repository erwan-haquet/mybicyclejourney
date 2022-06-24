<?php

namespace App\ContentManagement\Application\Components\Query;

use App\ContentManagement\Ui\Components\Web\Dto\Navbar\NavbarDto;
use Library\CQRS\Query\Query;
use Symfony\Component\HttpFoundation\Request;

/**
 * Finds the necessary resources to build the navbar.
 *
 * @see NavbarDto
 */
class FindNavbar extends Query
{
    /**
     * The current page request.
     */
    public Request $request;
}

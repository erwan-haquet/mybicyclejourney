<?php

namespace App\ContentManagement\Application\Components\Query;

use App\ContentManagement\Ui\Components\Web\Dto\Navbar\LocaleSwitcherDto;
use App\ContentManagement\Ui\Components\Web\Dto\Navbar\NavbarDto;
use Library\CQRS\Query\QueryHandlerInterface;

class BuildNavbarHandler implements QueryHandlerInterface
{
    public function __invoke(BuildNavbar $query): NavbarDto
    {
        return new NavbarDto([
            'localeSwitcher' => new LocaleSwitcherDto([
                'route' => $query->route,
                'queryParams' => $query->queryParams
            ])
        ]);
    }
}

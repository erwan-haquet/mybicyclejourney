<?php

namespace App\ContentManagement\Application\Components\Query;

use App\ContentManagement\Ui\Components\Web\Dto\Navbar\LocaleSwitcherDto;
use App\ContentManagement\Ui\Components\Web\Dto\Navbar\NavbarDto;
use Library\CQRS\Query\QueryHandlerInterface;

class FindNavbarHandler implements QueryHandlerInterface
{
    public function __invoke(FindNavbar $query): NavbarDto
    {
        $routeParams = $query->request->attributes->get('_route_params') ?? [];
        $queryParams = $query->request->query->all();
        
        return new NavbarDto([
            'localeSwitcher' => new LocaleSwitcherDto([
                'route' => $query->request->attributes->get('_route'),
                'queryParams' => array_merge($routeParams, $queryParams)
            ])
        ]);
    }
}

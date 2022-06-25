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
        $params = array_merge($routeParams, $queryParams);

        $route = $query->request->attributes->get('_route', 'homepage');

        return new NavbarDto([
            'localeSwitcher' => new LocaleSwitcherDto([
                'route' => $route,
                'queryParams' => $params
            ])
        ]);
    }
}

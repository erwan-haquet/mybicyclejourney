<?php

namespace App\ContentManagement\Ui\Frontend\Components\Controller;

use App\ContentManagement\Ui\Frontend\Components\View\Navbar\LocaleSwitcher;
use App\ContentManagement\Ui\Frontend\Components\View\Navbar\Navbar;
use Library\CQRS\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/_components/navbar',
    name: 'frontend_components_navbar',
    requirements: ['_locale' => 'en']
)]
class NavbarController extends AbstractController
{
    /**
     * Embedded controller to render the navbar fragment.
     */
    public function __invoke(
        QueryBus     $queryBus,
        RequestStack $requestStack
    ): Response {
        // As this controller is a fragment @see https://symfony.com/doc/current/templates.html#embedding-controllers
        // the main request must be retrieved via the request stack.
        $mainRequest = $requestStack->getMainRequest();

        $routeParams = $mainRequest->attributes->get('_route_params') ?? [];
        $queryParams = $mainRequest->query->all();
        $params = array_merge($routeParams, $queryParams);
        $route = $mainRequest->attributes->get('_route');

        return $this->render('frontend/components/navbar/index.html.twig', [
            'navbar' => new Navbar([
                'localeSwitcher' => new LocaleSwitcher([
                    'route' => $route,
                    'queryParams' => $params
                ])
            ])
        ]);
    }
}

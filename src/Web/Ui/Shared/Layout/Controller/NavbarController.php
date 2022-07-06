<?php

namespace App\Web\Ui\Shared\Layout\Controller;

use App\Web\Ui\Shared\Layout\Dto\Navbar\LocaleSwitcher;
use App\Web\Ui\Shared\Layout\Dto\Navbar\Navbar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/_components/navbar',
    name: 'components_navbar',
    requirements: ['_locale' => 'en']
)]
class NavbarController extends AbstractController
{
    /**
     * Embedded controller to render the navbar fragment.
     */
    public function __invoke(RequestStack $requestStack): Response {
        // As this controller is a fragment @see https://symfony.com/doc/current/templates.html#embedding-controllers
        // the main request must be retrieved via the request stack.
        $mainRequest = $requestStack->getMainRequest();

        $routeParams = $mainRequest->attributes->get('_route_params') ?? [];
        $queryParams = $mainRequest->query->all();
        $params = array_merge($routeParams, $queryParams);
        $route = $mainRequest->attributes->get('_route');
        
        $navbar = new Navbar([
            'localeSwitcher' => new LocaleSwitcher([
                'route' => $route ?? 'homepage',
                'queryParams' => $params
            ])
        ]);

        return $this->render('web/shared/layout/navbar/index.html.twig', [
            'navbar' => $navbar
        ]);
    }
}

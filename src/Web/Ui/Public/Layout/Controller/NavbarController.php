<?php

namespace App\Web\Ui\Public\Layout\Controller;

use App\Web\Ui\Public\Layout\Dto\Navbar\LocaleSwitcherDto;
use App\Web\Ui\Public\Layout\Dto\Navbar\NavbarDto;
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
        
        $navbar = new NavbarDto([
            'localeSwitcher' => new LocaleSwitcherDto([
                'route' => $route ?? 'homepage',
                'queryParams' => $params
            ])
        ]);

        return $this->render('web/shared/components/navbar/index.html.twig', [
            'navbar' => $navbar
        ]);
    }
}

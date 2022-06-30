<?php

namespace App\ContentManagement\Ui\Components\Web\Controller;

use App\ContentManagement\Application\Components\Query\BuildNavbar;
use Library\CQRS\Query\QueryBus;
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
    public function __invoke(
        QueryBus     $queryBus,
        RequestStack $requestStack
    ): Response
    {
        // As this controller is a fragment @see https://symfony.com/doc/current/templates.html#embedding-controllers
        // the main request must be retrieved via the request stack.
        $mainRequest = $requestStack->getMainRequest();

        $routeParams = $mainRequest->attributes->get('_route_params') ?? [];
        $queryParams = $mainRequest->query->all();
        $params = array_merge($routeParams, $queryParams);
        $route = $mainRequest->attributes->get('_route');

        $query = new BuildNavbar([
            'route' => $route ?? 'homepage',
            'queryParams' => $params,
        ]);
        $navbar = $queryBus->query($query);

        return $this->render('web/shared/components/_navbar.html.twig', [
            'navbar' => $navbar
        ]);
    }
}

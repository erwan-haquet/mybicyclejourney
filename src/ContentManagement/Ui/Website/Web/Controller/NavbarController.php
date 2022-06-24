<?php

namespace App\ContentManagement\Ui\Website\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends AbstractController
{
    /**
     * Render the navbar.
     */
    public function __invoke(RequestStack $request): Response
    {
        $mainRequest = $request->getMainRequest();
        
        $route = $mainRequest->attributes->get('_route');
        $routeParams = $mainRequest->attributes->get('_route_params');
        $queryParams = $mainRequest->query->all();
        $params = array_merge($routeParams, $queryParams);
        
        return $this->render('web/shared/_navbar.html.twig', [
            'mainRoute' => $route,
            'mainParams' => $params,
        ]);
    }
}

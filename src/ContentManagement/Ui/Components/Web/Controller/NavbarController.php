<?php

namespace App\ContentManagement\Ui\Components\Web\Controller;

use App\ContentManagement\Application\Components\Query\FindNavbar;
use Library\CQRS\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends AbstractController
{
    /**
     * Render the navbar.
     */
    public function __invoke(
        QueryBus     $queryBus,
        RequestStack $requestStack
    ): Response
    {
        $query = new FindNavbar([
            'request' => $requestStack->getMainRequest()
        ]);
        $navbar = $queryBus->query($query);

        return $this->render('web/shared/components/_navbar.html.twig', [
            'navbar' => $navbar
        ]);
    }
}

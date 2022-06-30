<?php

namespace App\ContentManagement\Ui\Components\Web\Controller;

use App\ContentManagement\Application\Components\Query\FindNavbar;
use Library\CQRS\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * Render the navbar.
     */
    public function __invoke(
        QueryBus $queryBus,
        Request  $request
    ): Response
    {
        $query = new FindNavbar(['request' => $request]);
        $navbar = $queryBus->query($query);

        return $this->render('web/shared/components/_navbar.html.twig', [
            'navbar' => $navbar
        ]);
    }
}

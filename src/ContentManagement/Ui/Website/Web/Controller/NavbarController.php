<?php

namespace App\ContentManagement\Ui\Website\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends AbstractController
{
    /**
     * Render the navbar.
     */
    public function __invoke(Request $request): Response
    {
        return $this->render('web/shared/_navbar.html.twig');
    }
}

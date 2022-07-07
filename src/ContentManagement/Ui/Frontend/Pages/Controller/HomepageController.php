<?php

namespace App\ContentManagement\Ui\Frontend\Pages\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'frontend_homepage')]
class HomepageController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('frontend/pages/homepage/index.html.twig');
    }
}

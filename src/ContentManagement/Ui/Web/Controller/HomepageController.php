<?php

namespace App\ContentManagement\Ui\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'homepage')]
class HomepageController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('homepage/index.html.twig');
    }
}
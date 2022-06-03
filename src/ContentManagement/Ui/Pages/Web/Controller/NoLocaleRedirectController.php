<?php

namespace App\ContentManagement\Ui\Pages\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class NoLocaleRedirectController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->redirectToRoute('homepage', ['_locale' => 'en']);
    }
}

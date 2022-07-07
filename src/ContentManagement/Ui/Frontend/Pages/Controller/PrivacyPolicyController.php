<?php

namespace App\ContentManagement\Ui\Frontend\Pages\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route([
    'en' => '/privacy-policy',
    'fr' => '/politique-de-confidentialite',
], name: 'frontend_privacy_policy')]
class PrivacyPolicyController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('frontend/pages/privacy_policy/index.html.twig');
    }
}

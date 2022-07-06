<?php

namespace App\Web\Ui\Public\Pages\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route([
    'en' => '/privacy-policy',
    'fr' => '/politique-de-confidentialite',
], name: 'privacy_policy')]
class PrivacyPolicyController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('web/pages/privacy_policy/index.html.twig');
    }
}

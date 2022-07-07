<?php

namespace App\ContentManagement\Ui\Dashboard\Pages\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route([
    'en' => '/dashboard',
    'fr' => '/tableau-de-bord',
], name: 'dashboard')]
class HomepageController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     */
    public function __invoke(): Response
    {
        return $this->render('web/dashboard/homepage/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}

<?php

namespace App\AccountManagement\Ui\Frontend\User\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/logout', name: 'frontend_logout', methods: ['GET'])]
class LogoutController extends AbstractController
{
    public function __invoke(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

<?php

namespace App\AccountManagement\Ui\Frontend\User\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/login', name: 'frontend_login')]
class LoginController extends AbstractController
{
    public function __invoke(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        // @see https://symfony.com/doc/current/security.html#form-login
        return $this->render('frontend/security/authentication/login.html.twig', [
            'last_email' => $lastUsername,
            'error' => $error
        ]);
    }
}

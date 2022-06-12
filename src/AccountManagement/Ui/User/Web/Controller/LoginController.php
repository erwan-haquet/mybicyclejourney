<?php

namespace App\AccountManagement\Ui\User\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/login', name: 'login')]
class LoginController extends AbstractController
{
    public function __invoke(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return new Response('', Response::HTTP_INTERNAL_SERVER_ERROR);

        // TODO: implement login form
        // @see https://symfony.com/doc/current/security.html#form-login
        // return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
}

<?php

namespace App\AccountManagement\Ui\Frontend\User\Controller;

use App\AccountManagement\Application\User\Command\RequestPasswordReset;
use App\AccountManagement\Ui\Frontend\User\Form\RequestPasswordResetFormType;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reset-password', name: 'frontend_request_password_reset')]
class RequestPasswordResetController extends AbstractController
{
    /**
     * Display & process form to request a password reset.
     */
    public function __invoke(
        Request    $request,
        CommandBus $commandBus,
    ): Response
    {
        $command = new RequestPasswordReset();
        $form = $this->createForm(RequestPasswordResetFormType::class, $command);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commandBus->handle($command);
            
            return $this->redirectToRoute('frontend_reset_password_check_email');
        }

        return $this->render('frontend/security/resetting/request_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

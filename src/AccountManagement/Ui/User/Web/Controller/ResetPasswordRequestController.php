<?php

namespace App\AccountManagement\Ui\User\Web\Controller;

use App\AccountManagement\Application\User\Command\RequestPasswordReset;
use App\AccountManagement\Ui\User\Web\Form\RequestPasswordResetFormType;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reset-password',
    name: 'reset_password_request',
    requirements: ["_locale" => "en"],
    locale: "en"
)]
class ResetPasswordRequestController extends AbstractController
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
            return $this->redirectToRoute('reset_password_check_email');
        }

        return $this->render('web/account_management/reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }
}

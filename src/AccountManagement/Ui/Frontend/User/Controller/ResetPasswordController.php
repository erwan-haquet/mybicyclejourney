<?php

namespace App\AccountManagement\Ui\Frontend\User\Controller;

use App\AccountManagement\Application\User\Command\ChangePassword;
use App\AccountManagement\Domain\User\Model\User;
use App\AccountManagement\Infrastructure\User\Security\LoginFormAuthenticator;
use App\AccountManagement\Ui\Frontend\User\Form\ChangePasswordFormType;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route('/reset-password/reset/{token}', name: 'reset_password_reset')]
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    /**
     * Validates and process the reset URL that the user clicked in their email.
     */
    public function __invoke(
        Request                      $request,
        TranslatorInterface          $translator,
        ResetPasswordHelperInterface $resetPasswordHelper,
        CommandBus                   $commandBus,
        UserAuthenticatorInterface   $authenticator,
        LoginFormAuthenticator       $formAuthenticator,
        RequestStack                 $requestStack,
        string                       $token = null
    ): Response
    {
        if ($token) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);
            return $this->redirectToRoute('reset_password_reset');
        }

        $token = $this->getTokenFromSession();
        if (null === $token) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }

        try {
            /** @var User $user */
            $user = $resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('warning', sprintf(
                '%s - %s',
                $translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE, [], 'ResetPasswordBundle'),
                $translator->trans($e->getReason(), [], 'ResetPasswordBundle')
            ));

            return $this->redirectToRoute('request_password_reset');
        }

        // The token is now valid.
        // Allow the user to change their password.

        $command = new ChangePassword([
            'userId' => $user->id(),
            'token' => $token
        ]);
        $form = $this->createForm(ChangePasswordFormType::class, $command);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commandBus->handle($command);
            
            $this->addFlash('success', new TranslatableMessage('global.welcome_back'));

            // The session is cleaned up after the password has been changed.
            $session = $requestStack->getSession();
            $session->remove('ResetPasswordPublicToken');
            $session->remove('ResetPasswordCheckEmail');
            $session->remove('ResetPasswordToken');
            
            return $authenticator->authenticateUser(
                $user,
                $formAuthenticator,
                $request
            );
        }

        return $this->render('frontend/security/resetting/reset_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

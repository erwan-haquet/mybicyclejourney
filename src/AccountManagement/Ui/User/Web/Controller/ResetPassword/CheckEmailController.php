<?php

namespace App\AccountManagement\Ui\User\Web\Controller\ResetPassword;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * Confirmation page after a user has requested a password reset.
 */
#[Route('/reset-password/check-email',
    name: 'reset_password_check_email',
    requirements: ["_locale" => "en"],
    locale: "en"
)]
class CheckEmailController extends AbstractController
{
    use ResetPasswordControllerTrait;
    
    public function __invoke(ResetPasswordHelperInterface $resetPasswordHelper,): Response
    {
        // Generate a fake token if the user does not exist or someone hit this page directly.
        // This prevents exposing whether or not a user was found with the given email address or not
        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $resetPasswordHelper->generateFakeResetToken();
        }

        return $this->render('web/account_management/reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);
    }
}

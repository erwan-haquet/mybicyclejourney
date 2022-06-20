<?php

namespace App\AccountManagement\Ui\User\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route('/reset-password/check-email',
    name: 'reset_password_check_email',
    requirements: ["_locale" => "en"],
    locale: "en"
)]
class ResetPasswordCheckEmailController extends AbstractController
{
    use ResetPasswordControllerTrait;

    /**
     * Confirmation page after a user has requested a password reset.
     */
    public function __invoke(ResetPasswordHelperInterface $resetPasswordHelper): Response
    {
        $resetToken = $this->getTokenObjectFromSession();
        
        // Generate a fake token if the user does not exist or someone hit this page directly.
        // This prevents exposing whether or not a user was found with the given email address or not
        if (null === $resetToken) {
            $resetToken = $resetPasswordHelper->generateFakeResetToken();
        }

        return $this->render('web/account_management/reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);
    }
}

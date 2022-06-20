<?php

namespace App\AccountManagement\Application\User\Command;

use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use App\Supporting\Domain\Email\MailerInterface;
use App\Supporting\Domain\Email\Model\Email;
use Library\CQRS\Command\CommandHandlerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use Twig\Environment;

class RequestPasswordResetHandler implements CommandHandlerInterface
{
    private TranslatorInterface $translator;
    private RequestStack $requestStack;
    private UserRepositoryInterface $userRepository;
    private Environment $twig;
    private ResetPasswordHelperInterface $resetPasswordHelper;
    private MailerInterface $mailer;

    public function __construct(
        TranslatorInterface          $translator,
        RequestStack                 $requestStack,
        UserRepositoryInterface      $userRepository,
        Environment                  $twig,
        MailerInterface              $mailer,
        ResetPasswordHelperInterface $resetPasswordHelper
    )
    {
        $this->translator = $translator;
        $this->requestStack = $requestStack;
        $this->userRepository = $userRepository;
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    public function __invoke(RequestPasswordReset $command): void
    {
        // Do not reveal whether a user account was found or not.
        if (!$user = $this->userRepository->findByEmail($command->email)) {
            return;
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $exception) {
            return;
        }

        $context = [
            'resetToken' => $resetToken,
            'locale' => $user->locale()
        ];

        $email = new Email(
            subject: $this->translator->trans(
                id: "account_management.reset_password.subject",
                domain: "email",
                locale: $user->locale()
            ),
            to: $user->email(),
            text: $this->twig->render('email/account_management/reset_password/email.txt.twig', $context),
        );

        $this->mailer->send($email);

        // Store the token object in session for retrieval in check-email route.
        $resetToken->clearToken();
        $this->requestStack
            ->getSession()
            ->set('ResetPasswordToken', $resetToken);

    }
}

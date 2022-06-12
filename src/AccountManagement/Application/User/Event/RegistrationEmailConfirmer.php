<?php

namespace App\AccountManagement\Application\User\Event;

use App\AccountManagement\Domain\User\Event\UserRegistered;
use App\AccountManagement\Domain\User\Model\UserId;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use App\Supporting\Domain\Email\MailerInterface;
use App\Supporting\Domain\Email\Model\Email;
use Library\Assert\Assert;
use Library\CQRS\Event\EventHandlerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class RegistrationEmailConfirmer implements EventHandlerInterface
{
    private UserRepositoryInterface $repository;
    private MailerInterface $mailer;
    private Environment $twig;
    private VerifyEmailHelperInterface $verifyEmailHelper;
    private TranslatorInterface $translator;

    public function __construct(
        UserRepositoryInterface    $repository,
        MailerInterface            $mailer,
        Environment                $twig,
        VerifyEmailHelperInterface $verifyEmailHelper,
        TranslatorInterface        $translator,
    )
    {
        $this->repository = $repository;
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->verifyEmailHelper = $verifyEmailHelper;
        $this->translator = $translator;
    }

    public function __invoke(UserRegistered $event): void
    {
        $id = UserId::fromString($event->getUserId());
        $user = $this->repository->findById($id);

        Assert::notNull($user, sprintf('No user found for id: %s', $id));

        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            'verify_email',
            $user->email(),
            $user->email(),
            ['id' => $user->id()]
        );

        $context = [
            'name' => $user->username(),
            'locale' => $user->locale(),
            'signedUrl' => $signatureComponents->getSignedUrl(),
            'expiresAtMessageKey' => $signatureComponents->getExpirationMessageKey(),
            'expiresAtMessageData' => $signatureComponents->getExpirationMessageData(),
        ];

        $email = new Email(
            subject: $this->translator->trans(
                id: "account_management.email_confirmation.subject",
                domain: "email"
            ),
            to: $user->email(),
            text: $this->twig->render('email/account_management/registration/email_confirmation.txt.twig', $context),
        );

        $this->mailer->send($email);
    }
}

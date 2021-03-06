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
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Twig\Environment;

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
            'locale' => $user->locale(),
            'signedUrl' => $signatureComponents->getSignedUrl(),
            'expiresAtMessageKey' => $signatureComponents->getExpirationMessageKey(),
            'expiresAtMessageData' => $signatureComponents->getExpirationMessageData(),
        ];

        $email = new Email(
            subject: $this->translator->trans(
                id: "user.email_confirmation.subject",
                domain: "email",
                locale: $user->locale()
            ),
            to: $user->email(),
            text: $this->twig->render('email/user/signup_email_confirmation.txt.twig', $context),
        );

        $this->mailer->send($email);
    }
}

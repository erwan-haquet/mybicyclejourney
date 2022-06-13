<?php

namespace App\Marketing\Application\Launch\Event;

use App\Marketing\Domain\Launch\Event\EarlyBirdRegistered;
use App\Marketing\Domain\Launch\Repository\EarlyBirdRepositoryInterface;
use App\Supporting\Domain\Email\MailerInterface;
use App\Supporting\Domain\Email\Model\Email;
use Library\Assert\Assert;
use Library\CQRS\Event\EventHandlerInterface;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class EarlyBirdRegisteredUserNotifier implements EventHandlerInterface
{
    private EarlyBirdRepositoryInterface $repository;
    private MailerInterface $mailer;
    private Environment $twig;
    private TranslatorInterface $translator;

    public function __construct(
        EarlyBirdRepositoryInterface $repository,
        MailerInterface              $mailer,
        TranslatorInterface          $translator,
        Environment                  $twig
    )
    {
        $this->repository = $repository;
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->twig = $twig;
    }

    public function __invoke(EarlyBirdRegistered $event): void
    {
        $earlyBird = $this->repository->findById($event->getEarlyBirdId());
        Assert::notNull($earlyBird, sprintf('No early bird found for id: %s', $event->getEarlyBirdId()));

        $context = [
            'name' => $earlyBird->getName(),
            'locale' => $earlyBird->getLocale(),
        ];

        $email = new Email(
            subject: $this->translator->trans(
                id: "marketing_launch.early_bird_welcome.subject",
                domain: "email",
                locale: $earlyBird->getLocale()
            ),
            to: $earlyBird->getEmail(),
            text: $this->twig->render('email/marketing/launch/early_bird_welcome.txt.twig', $context),
        );

        $this->mailer->send($email);
    }
}

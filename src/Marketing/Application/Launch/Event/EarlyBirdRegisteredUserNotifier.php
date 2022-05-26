<?php

namespace App\Marketing\Application\Launch\Event;

use App\Marketing\Domain\Launch\Event\EarlyBirdRegistered;
use App\Marketing\Domain\Launch\Repository\EarlyBirdRepositoryInterface;
use App\Supporting\Domain\Email\MailerInterface;
use App\Supporting\Domain\Email\Model\Email;
use Library\Assert\Assert;
use Library\CQRS\Event\EventHandlerInterface;
use Twig\Environment;

class EarlyBirdRegisteredUserNotifier implements EventHandlerInterface
{
    private EarlyBirdRepositoryInterface $repository;
    private MailerInterface $mailer;
    private Environment $twig;

    public function __construct(
        EarlyBirdRepositoryInterface $repository,
        MailerInterface              $mailer,
        Environment                  $twig
    )
    {
        $this->repository = $repository;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function __invoke(EarlyBirdRegistered $event): void
    {
//        $earlyBird = $this->repository->findById($event->getEarlyBirdId());
//        Assert::notNull($earlyBird, sprintf('No early bird found for id: %s', $earlyBird->getId()));
//
//        $context = [
//            'name' => $earlyBird->getName()
//        ];
//
//        $email = new Email(
//            subject: 'Welcome to My Bicycle Journey - Merci de nous suivre :)',
//            to: $earlyBird->getEmail(),
//            text: $this->twig->render('email/marketing/launch/early_bird_welcome.txt.twig', $context),
//            html: $this->twig->render('email/marketing/launch/early_bird_welcome.markdown.twig', $context)
//        );
//
//        $this->mailer->send($email);
    }
}

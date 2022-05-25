<?php

namespace App\Marketing\Application\Launch\Command;

use App\Marketing\Domain\Launch\Exception\EmailIsAlreadyRegistered;
use App\Marketing\Domain\Launch\Model\EarlyBird;
use App\Marketing\Domain\Launch\Repository\EarlyBirdRepositoryInterface;
use App\Supporting\Domain\Email\MailerInterface;
use App\Supporting\Domain\Email\Model\Email;
use Library\CQRS\Command\CommandHandlerInterface;

class RegisterEarlyBirdHandler implements CommandHandlerInterface
{
    private EarlyBirdRepositoryInterface $repository;
    private MailerInterface $mailer;

    public function __construct(
        EarlyBirdRepositoryInterface $repository,
        MailerInterface              $mailer
    )
    {
        $this->repository = $repository;
        $this->mailer = $mailer;
    }

    /**
     * @throws EmailIsAlreadyRegistered
     */
    public function __invoke(RegisterEarlyBird $command): void
    {
        $earlyBird = new EarlyBird(
            email: $command->email,
            name: $command->name,
        );

        $this->repository->add($earlyBird);

        $email = new Email(
            subject: 'Early bird registered',
            to: $command->email,
            text: 'Welcome on board !'
        );

        $this->mailer->send($email);
    }
}

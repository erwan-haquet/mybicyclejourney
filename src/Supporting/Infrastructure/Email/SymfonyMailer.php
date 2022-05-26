<?php

namespace App\Supporting\Infrastructure\Email;

use App\Supporting\Domain\Email\MailerInterface;
use App\Supporting\Domain\Email\Model\Email;
use Symfony\Component\Mailer\MailerInterface as Mailer;
use Symfony\Component\Mime\Crypto\DkimSigner;
use Symfony\Component\Mime\Email as SymfonyEmail;

class SymfonyMailer implements MailerInterface
{
    private Mailer $mailer;
    private string $sender;
    private ?DkimSigner $dkimSigner = null;

    public function __construct(
        Mailer $mailer,
        string $sender,
        string $dkimPk = null,
        string $dkimDomain = null,
        string $dkimSelector = null
    )
    {
        $this->mailer = $mailer;
        $this->sender = $sender;

        if (null !== $dkimPk) {
            $this->dkimSigner = new DkimSigner($dkimPk, $dkimDomain, $dkimSelector);
        }
    }

    public function send(Email $email)
    {
        $message = (new SymfonyEmail())
            ->from($this->sender)
            ->to(...$email->to())
            ->cc(...$email->cc())
            ->subject($email->subject())
            ->text($email->text());

        if ($html = $email->html()) {
            $message->html($html);
        }

        foreach ($email->attachments() as $attachment) {
            $message->attachFromPath(
                path: $attachment->getPath(),
                name: $attachment->getName(),
                contentType: $attachment->getContentType()
            );
        }

        if (null !== $this->dkimSigner) {
            $message = $this->dkimSigner->sign($message);
        }

        $this->mailer->send($message);
    }
}

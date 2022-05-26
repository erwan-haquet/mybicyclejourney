<?php

namespace App\Supporting\Domain\Email;

use App\Supporting\Domain\Email\Model\Email;

interface MailerInterface
{
    /**
     * Send an email.
     */
    public function send(Email $email);
}

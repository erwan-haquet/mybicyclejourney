<?php

namespace App\Supporting\Domain\Email\Model;

/**
 * An immutable email value object.
 */
class Email
{
    private string $subject;

    /**
     * @var string[]
     */
    private array $to;

    /**
     * @var string[]
     */
    private array $cc;

    /**
     * @var Attachment[]
     */
    private array $attachments;

    private string $text;

    private ?string $html;

    public function __construct(
        string       $subject,
        string|array $to,
        string       $text,
        string       $html = null,
        string|array $cc = [],
        array        $attachments = [],
    )
    {
        $this->subject = $subject;
        $this->attachments = $attachments;
        $this->text = $text;
        $this->html = $html;

        $this->to = is_array($to) ? $to : [$to];
        $this->cc = is_array($cc) ? $cc : [$cc];
    }

    /**
     * Email's subject.
     */
    public function subject(): string
    {
        return $this->subject;
    }

    /**
     * Recipients email addresses.
     *
     * @return string[]
     */
    public function to(): array
    {
        return $this->to;
    }

    /**
     * Cc email addresses.
     *
     * @return string[]
     */
    public function cc(): array
    {
        return $this->cc;
    }

    /**
     * @return Attachment[]
     */
    public function attachments(): array
    {
        return $this->attachments;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function html(): ?string
    {
        return $this->html;
    }
}

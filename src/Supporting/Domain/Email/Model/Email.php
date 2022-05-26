<?php

namespace App\Supporting\Domain\Email\Model;

use Library\Assert\Assert;

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
     * @var PathAttachment[]
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

        $this->text = $text;
        $this->html = $html;

        Assert::allIsInstanceOf($attachments, PathAttachment::class);
        $this->attachments = $attachments;

        $this->to = is_array($to) ? $to : [$to];
        Assert::allString($this->to, PathAttachment::class);

        $this->cc = is_array($cc) ? $cc : [$cc];
        Assert::allString($this->cc, PathAttachment::class);
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
     * @return PathAttachment[]
     */
    public function attachments(): array
    {
        return $this->attachments;
    }

    /**
     * Text content.
     */
    public function text(): string
    {
        return $this->text;
    }

    /**
     * Html content.
     */
    public function html(): ?string
    {
        return $this->html;
    }
}

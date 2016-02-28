<?php

namespace ZfrMail\Mail;

/**
 * @author Michaël Gallego
 */
abstract class AbstractMail implements MailInterface
{
    /**
     * @var string
     */
    private $from = '';

    /**
     * @var string
     */
    private $to = '';

    /**
     * @var array
     */
    private $cc = [];

    /**
     * @var array
     */
    private $bcc = [];

    /**
     * @var string
     */
    private $replyTo = '';

    /**
     * @var AttachmentInterface[]
     */
    private $attachments = [];

    /**
     * @var array
     */
    private $options = [];

    /**
     * {@inheritDoc}
     */
    public function withFrom(string $from): MailInterface
    {
        $new = clone $this;
        $new->from = $from;

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * {@inheritDoc}
     */
    public function withTo(string $to): MailInterface
    {
        $new = clone $this;
        $new->to = $to;

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * {@inheritDoc}
     */
    public function withCc(array $cc): MailInterface
    {
        $new = clone $this;
        $new->cc = $cc;

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getCc(): array
    {
        return $this->cc;
    }

    /**
     * {@inheritDoc}
     */
    public function withBcc(array $bcc): MailInterface
    {
        $new = clone $this;
        $new->bcc = $bcc;

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getBcc(): array
    {
        return $this->bcc;
    }

    /**
     * {@inheritDoc}
     */
    public function withReplyTo(string $replyTo): MailInterface
    {
        $new = clone $this;
        $new->replyTo = $replyTo;

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getReplyTo(): string
    {
        return $this->replyTo;
    }

    /**
     * {@inheritDoc}
     */
    public function withAttachment(AttachmentInterface $attachment): MailInterface
    {
        $new = clone $this;
        $new->attachments[] = $attachment;

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * {@inheritDoc}
     */
    public function withOptions(array $options): MailInterface
    {
        $new = clone $this;
        $new->options = $options;

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}

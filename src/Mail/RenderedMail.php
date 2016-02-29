<?php

namespace ZfrMail\Mail;

/**
 * @author Michaël Gallego
 */
class RenderedMail extends AbstractMail implements RenderedMailInterface
{
    /**
     * @var string
     */
    private $subject = '';

    /**
     * @var string
     */
    private $textBody = '';

    /**
     * @var string
     */
    private $htmlBody = '';

    /**
     * {@inheritDoc}
     */
    public function withSubject(string $subject): RenderedMailInterface
    {
        $new = clone $this;
        $new->subject = $subject;

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * {@inheritDoc}
     */
    public function withTextBody(string $textBody): RenderedMailInterface
    {
        $new = clone $this;
        $new->textBody = $textBody;

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getTextBody(): string
    {
        return $this->textBody;
    }

    /**
     * {@inheritDoc}
     */
    public function withHtmlBody(string $htmlBody): RenderedMailInterface
    {
        $new = clone $this;
        $new->htmlBody = $htmlBody;

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getHtmlBody(): string
    {
        return $this->htmlBody;
    }
}

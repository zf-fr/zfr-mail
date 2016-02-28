<?php

namespace ZfrMail\Mail;

/**
 * Interface for a mail that you render manually
 *
 * @author Michaël Gallego
 */
interface RenderedMailInterface extends MailInterface
{
    /**
     * Add a new subject to the email
     *
     * @param  string $subject
     * @return static
     */
    public function withSubject(string $subject): RenderedMailInterface;

    /**
     * Get the subject
     *
     * @return string
     */
    public function getSubject(): string;

    /**
     * Add a text body
     *
     * @param  string $textBody
     * @return static
     */
    public function withTextBody(string $textBody): RenderedMailInterface;

    /**
     * Get the text body
     *
     * @return string
     */
    public function getTextBody(): string;

    /**
     * Add a HTML body
     *
     * @param  string $htmlBody
     * @return static
     */
    public function withHtmlBody(string $htmlBody): RenderedMailInterface;

    /**
     * Get the text body
     *
     * @return string
     */
    public function getHtmlBody(): string;
}

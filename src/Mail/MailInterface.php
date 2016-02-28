<?php

namespace ZfrMail\Mail;

/**
 * Simple interface for a mail
 *
 * @author Michaël Gallego
 */
interface MailInterface
{
    /**
     * Add a new "from" address and return a new mail
     *
     * @param  string $from
     * @return static
     */
    public function withFrom(string $from): MailInterface;

    /**
     * Get the "from" email
     *
     * @return string
     */
    public function getFrom(): string;

    /**
     * Add a new "to" address and return a new mail
     *
     * @param  string $to
     * @return static
     */
    public function withTo(string $to): MailInterface;

    /**
     * Get the "to" email
     *
     * @return string
     */
    public function getTo(): string;

    /**
     * Add a new "cc" addresses and return a new mail
     *
     * @param  array $cc
     * @return static
     */
    public function withCc(array $cc): MailInterface;

    /**
     * Get the "cc" emails
     *
     * @return array
     */
    public function getCc(): array;

    /**
     * Add a new "bcc" addresses and return a new mail
     *
     * @param  array $bcc
     * @return static
     */
    public function withBcc(array $bcc): MailInterface;

    /**
     * Get the "bcc" emails
     *
     * @return array
     */
    public function getBcc(): array;

    /**
     * Set new options (the options are related to the mailer you use)
     *
     * @param  array $options
     * @return static
     */
    public function withOptions(array $options): MailInterface;

    /**
     * Get the options
     *
     * @return array
     */
    public function getOptions(): array;
}

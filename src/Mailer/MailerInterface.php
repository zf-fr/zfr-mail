<?php

namespace ZfrMail\Mailer;

use ZfrMail\Mail\RenderedMailInterface;
use ZfrMail\Mail\TemplatedMailInterface;

/**
 * @author Michaël Gallego
 */
interface MailerInterface
{
    /**
     * Send an email rendered manually
     *
     * @param  RenderedMailInterface $mail
     * @return void
     */
    public function sendMail(RenderedMailInterface $mail);

    /**
     * Send a templated email (for providers that support it)
     *
     * @param  TemplatedMailInterface $templatedMail
     * @return void
     */
    public function sendTemplatedMail(TemplatedMailInterface $templatedMail);
}

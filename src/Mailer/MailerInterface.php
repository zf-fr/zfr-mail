<?php

namespace ZfrMail\Mailer;

use ZfrMail\Mail\MailInterface;

/**
 * @author Michaël Gallego
 */
interface MailerInterface
{
    /**
     * Send a mail
     *
     * The mailer must check whether the mail is a rendered or templated mail, and
     * choose the right HTTP resource for the given provider
     *
     * @param  MailInterface $mail
     * @return void
     */
    public function send(MailInterface $mail);
}

<?php

namespace ZfrMail\Mailer;

use ZfrMail\Mail\MailInterface;
use ZfrMail\Mail\TemplatedMailInterface;

/**
 * @author Michaël Gallego
 */
interface MailerInterface
{
    /**
     * @param  MailInterface $mail
     * @return void
     */
    public function sendMail(MailInterface $mail);

    /**
     * @param  TemplatedMailInterface $templatedMail
     * @return void
     */
    public function setTemplatedMail(TemplatedMailInterface $templatedMail);
}
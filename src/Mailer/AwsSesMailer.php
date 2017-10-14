<?php

namespace ZfrMail\Mailer;

use Aws\Result;
use Aws\Ses\SesClient;
use ZfrMail\Exception\InvalidArgumentException;
use ZfrMail\Exception\RuntimeException;
use ZfrMail\Mail\MailInterface;
use ZfrMail\Mail\RenderedMailInterface;
use ZfrMail\Mail\TemplatedMailInterface;

/**
 * @author Florent Blaison
 */
class AwsSesMailer implements MailerInterface
{
    /**
     * SES supports a maximum of 50 recipients per messages
     */
    const RECIPIENT_LIMIT = 50;

    /**
     * @var SesClient
     */
    private $sesClient;

    /**
     * AwsSesMailer constructor.
     *
     * @param SesClient $sesClient
     */
    public function __construct(SesClient $sesClient)
    {
        $this->sesClient = $sesClient;
    }

    /**
     * {@inheritDoc}
     */
    public function send(MailInterface $mail)
    {
        $countRecipients = $this->countRecipients($mail);
        if ($countRecipients > self::RECIPIENT_LIMIT) {
            throw new RuntimeException(
                sprintf(
                    'You have exceeded limitation for Amazon SES count recipients (%s maximum, %s given)',
                    self::RECIPIENT_LIMIT,
                    $countRecipients
                )
            );
        }

        if ($mail instanceof RenderedMailInterface) {
            $result = $this->sendRenderedMail($mail);
        } elseif ($mail instanceof TemplatedMailInterface) {
            $result = $this->sendTemplatedMail($mail);
        } else {
            throw new InvalidArgumentException(
                sprintf('Unable to send email with %s for %s', __CLASS__, get_class($mail))
            );
        }

        return $result->get('MessageId');
    }

    /**
     * {@inheritDoc}
     */
    private function sendRenderedMail(RenderedMailInterface $mail) : Result
    {
        return $this->sesClient->sendEmail($this->getRequestOptions($mail));
    }

    /**
     * {@inheritDoc}
     */
    private function sendTemplatedMail(TemplatedMailInterface $mail) : Result
    {
        return $this->sesClient->sendTemplatedEmail($this->getRequestOptions($mail));
    }

    /**
     * @param  MailInterface $mail
     *
     * @return array
     */
    private function getRequestOptions(MailInterface $mail) : array
    {
        $requestOptions = [
            'Source' => $mail->getFrom(),
            'Destination' => [
                'ToAddresses' => explode(',', $mail->getTo()),
            ],
        ];

        if (! empty($mail->getCc())) {
            $requestOptions['Destination']['CcAddresses'] = $mail->getCc();
        }

        if (! empty($mail->getBcc())) {
            $requestOptions['Destination']['BccAddresses'] = $mail->getBcc();
        }

        if ($mail->getReplyTo()) {
            $requestOptions['ReplyToAddresses'] = explode(',', $mail->getReplyTo());
        }

        if ($mail instanceof RenderedMailInterface) {
            $requestOptions = array_merge(
                $requestOptions,
                [
                    'Message' => [
                        'Subject' => [
                            'Data' => $mail->getSubject(),
                        ],
                        'Body' => [
                            'Text' => [
                                'Data' => $mail->getTextBody(),
                            ],
                            'Html' => [
                                'Data' => $mail->getHtmlBody(),
                            ],
                        ],
                    ],
                ]
            );
        } elseif ($mail instanceof TemplatedMailInterface) {
            $requestOptions = array_merge(
                $requestOptions,
                [
                    'Template' => $mail->getTemplate(),
                    'TemplateData' => $mail->getTemplateVariables(),
                ]
            );
        }

        return array_filter($requestOptions);
    }

    /**
     * @param MailInterface $mail
     *
     * @return int
     */
    private function countRecipients(MailInterface $mail) : int
    {
        $countRecipients = count(explode(',', $mail->getTo()));
        $countRecipients += count($mail->getCc());
        $countRecipients += count($mail->getBcc());

        return $countRecipients;
    }
}

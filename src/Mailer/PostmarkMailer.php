<?php

namespace ZfrMail\Mailer;

use GuzzleHttp\ClientInterface;
use ZfrMail\Mail\MailInterface;
use ZfrMail\Mail\RenderedMailInterface;
use ZfrMail\Mail\TemplatedMailInterface;

/**
 * @author Michaël Gallego
 */
class PostmarkMailer implements MailerInterface
{
    const POSTMARK_BASE_API = 'https://api.postmarkapp.com';

    /**
     * @var string
     */
    private $serverToken;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @param string          $serverToken
     * @param ClientInterface $httpClient
     */
    public function __construct(string $serverToken, ClientInterface $httpClient)
    {
        $this->serverToken = $serverToken;
        $this->httpClient  = $httpClient;
    }

    /**
     * {@inheritDoc}
     */
    public function send(MailInterface $mail)
    {
        if ($mail instanceof RenderedMailInterface) {
            $this->sendRenderedMail($mail);
        } elseif ($mail instanceof TemplatedMailInterface) {
            $this->sendTemplatedMail($mail);
        }
    }

    /**
     * {@inheritDoc}
     */
    private function sendRenderedMail(RenderedMailInterface $mail)
    {
        $this->httpClient->request('post', self::POSTMARK_BASE_API . '/email', [
            'headers' => [
                'X-Postmark-Server-Token' => $this->serverToken
            ],
            'json' => array_filter($this->getRequestOptions($mail))
        ]);
    }

    /**
     * {@inheritDoc}
     */
    private function sendTemplatedMail(TemplatedMailInterface $mail)
    {
        $this->httpClient->request('post', self::POSTMARK_BASE_API . '/email/withTemplate', [
            'headers' => [
                'X-Postmark-Server-Token' => $this->serverToken
            ],
            'json' => array_filter($this->getRequestOptions($mail))
        ]);
    }

    /**
     * @param  MailInterface $mail
     * @return array
     */
    private function getRequestOptions(MailInterface $mail): array
    {
        $requestOptions = [
            'From' => $mail->getFrom(),
            'To'   => $mail->getTo(),
            'Cc'   => implode(',', $mail->getCc()),
            'Bcc'  => implode(',', $mail->getBcc()),
        ];

        foreach ($mail->getAttachments() as $attachment) {
            $requestOptions['Attachments'][] = [
                'Content'     => $attachment->getContent(),
                'ContentType' => $attachment->getContentType(),
                'Name'        => $attachment->getName(),
            ];
        }

        $validOptions = $this->filterPostmarkOptions($mail->getOptions());

        foreach ($validOptions as $key => $value) {
            $requestOptions[$key] = $value;
        }

        if ($mail instanceof RenderedMailInterface) {
            $requestOptions = array_merge($requestOptions, [
                'Subject'  => $mail->getSubject(),
                'TextBody' => $mail->getTextBody(),
                'HtmlBody' => $mail->getHtmlBody()
            ]);
        } elseif ($mail instanceof TemplatedMailInterface) {
            $requestOptions = array_merge($requestOptions, [
                'TemplateId'    => $mail->getTemplate(),
                'TemplateModel' => $mail->getTemplateVariables(),
            ]);
        }

        return $requestOptions;
    }

    /**
     * @param  array $options
     * @return array
     */
    private function filterPostmarkOptions(array $options): array
    {
        $validKeys = ['Tag', 'ReplyTo', 'Headers', 'TrackOpens', 'InlineCss'];

        return array_intersect_key($options, array_flip($validKeys));
    }
}

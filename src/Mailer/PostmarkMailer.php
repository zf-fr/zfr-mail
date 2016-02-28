<?php

namespace ZfrMail\Mailer;

use GuzzleHttp\ClientInterface;
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
    public function sendMail(RenderedMailInterface $mail)
    {
        $requestOptions = [
            'From'     => $mail->getFrom(),
            'To'       => $mail->getTo(),
            'Cc'       => implode(',', $mail->getCc()),
            'Bcc'      => implode(',', $mail->getBcc()),
            'Subject'  => $mail->getSubject(),
            'TextBody' => $mail->getTextBody(),
            'HtmlBody' => $mail->getHtmlBody()
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

        $this->httpClient->request('post', self::POSTMARK_BASE_API . '/email', [
            'headers' => [
                'X-Postmark-Server-Token' => $this->serverToken
            ],
            'json' => array_filter($requestOptions)
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function sendTemplatedMail(TemplatedMailInterface $mail)
    {
        $requestOptions = [
            'TemplateId'    => $mail->getTemplate(),
            'TemplateModel' => $mail->getTemplateVariables(),
            'From'          => $mail->getFrom(),
            'To'            => $mail->getTo(),
            'Cc'            => implode(',', $mail->getCc()),
            'Bcc'           => implode(',', $mail->getBcc()),
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

        $this->httpClient->request('post', self::POSTMARK_BASE_API . '/email', [
            'headers' => [
                'X-Postmark-Server-Token' => $this->serverToken
            ],
            'json' => array_filter($requestOptions)
        ]);
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
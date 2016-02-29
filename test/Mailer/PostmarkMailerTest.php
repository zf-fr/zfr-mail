<?php

namespace ZfrMailTest\Mailer;

use GuzzleHttp\ClientInterface;
use ZfrMail\Mail\Attachment;
use ZfrMail\Mail\RenderedMail;
use ZfrMail\Mail\TemplatedMail;
use ZfrMail\Mailer\PostmarkMailer;

class PostmarkMailerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $serverToken = 'token';

    /**
     * @var \Prophecy\Prophecy\ObjectProphecy
     */
    private $client;

    /**
     * @var PostmarkMailer
     */
    private $mailer;

    public function setUp()
    {
        $this->client = $this->prophesize(ClientInterface::class);
        $this->mailer = new PostmarkMailer($this->serverToken, $this->client->reveal());
    }

    public function testCanSendRenderedMail()
    {
        $renderedMail = new RenderedMail();
        $renderedMail = $renderedMail->withFrom('from@gmail.com')
            ->withTo('to@gmail.com')
            ->withBcc(['bcc1@gmail.com', 'bcc2@gmail.com'])
            ->withCc(['cc1@gmail.com', 'cc2@gmail.com'])
            ->withSubject('Hello')
            ->withTextBody('Hello world')
            ->withHtmlBody('<p>Hello world</p>')
            ->withAddedAttachment(new Attachment('content', 'content-type', 'name'));

        $params = [
            'headers' => [
                'X-Postmark-Server-Token' => $this->serverToken
            ],
            'json' => [
                'From'        => 'from@gmail.com',
                'To'          => 'to@gmail.com',
                'Cc'          => 'cc1@gmail.com,cc2@gmail.com',
                'Bcc'         => 'bcc1@gmail.com,bcc2@gmail.com',
                'Attachments' => [
                    [
                        'Content'     => 'content',
                        'ContentType' => 'content-type',
                        'Name'        => 'name'
                    ]
                ],
                'Subject'  => 'Hello',
                'TextBody' => 'Hello world',
                'HtmlBody' => '<p>Hello world</p>'
            ]
        ];

        $this->client->request('post', 'https://api.postmarkapp.com/email', $params)->shouldBeCalled();

        $this->mailer->send($renderedMail);
    }

    public function testCanSendTemplatedMail()
    {
        $templatedEmail = new TemplatedMail();
        $templatedEmail = $templatedEmail->withFrom('from@gmail.com')
            ->withTo('to@gmail.com')
            ->withBcc(['bcc1@gmail.com', 'bcc2@gmail.com'])
            ->withCc(['cc1@gmail.com', 'cc2@gmail.com'])
            ->withTemplate('template-123')
            ->withTemplateVariables(['foo' => 'bar'])
            ->withAddedAttachment(new Attachment('content', 'content-type', 'name'));

        $params = [
            'headers' => [
                'X-Postmark-Server-Token' => $this->serverToken
            ],
            'json' => [
                'From'        => 'from@gmail.com',
                'To'          => 'to@gmail.com',
                'Cc'          => 'cc1@gmail.com,cc2@gmail.com',
                'Bcc'         => 'bcc1@gmail.com,bcc2@gmail.com',
                'Attachments' => [
                    [
                        'Content'     => 'content',
                        'ContentType' => 'content-type',
                        'Name'        => 'name'
                    ]
                ],
                'TemplateId'    => 'template-123',
                'TemplateModel' => ['foo' => 'bar'],
            ]
        ];

        $this->client->request('post', 'https://api.postmarkapp.com/email/withTemplate', $params)->shouldBeCalled();

        $this->mailer->send($templatedEmail);
    }
}
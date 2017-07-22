<?php

namespace ZfrMailTest\Mailer;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
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

        $response = $this->createResponse();

        $this->client->request('post', 'https://api.postmarkapp.com/email', $params)->shouldBeCalled()->willReturn($response);

        $messageId = $this->mailer->send($renderedMail);

        $this->assertEquals('test', $messageId);
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

        $response = $this->createResponse();

        $this->client->request('post', 'https://api.postmarkapp.com/email/withTemplate', $params)->shouldBeCalled()->willReturn($response);

        $messageId = $this->mailer->send($templatedEmail);

        $this->assertEquals('test', $messageId);
    }

    private function createResponse(): ResponseInterface
    {
        $stream = $this->prophesize(StreamInterface::class);
        $stream->getContents()->shouldBeCalled()->willReturn('{"MessageID": "test"}');

        $response = $this->prophesize(ResponseInterface::class);
        $response->getBody()->shouldBeCalled()->willReturn($stream->reveal());

        return $response->reveal();
    }
}
<?php

namespace ZfrMailTest\Mailer;

use Aws\Result;
use Aws\Ses\SesClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use ZfrMail\Mail\RenderedMail;
use ZfrMail\Mail\TemplatedMail;
use ZfrMail\Mailer\AwsSesMailer;

/**
 * @author Florent Blaison
 */
class AwsSesMailerTest extends TestCase
{
    /**
     * @var \Prophecy\Prophecy\ObjectProphecy
     */
    private $sesClient;

    /**
     * @var AwsSesMailer
     */
    private $mailer;

    public function setUp()
    {
        $this->sesClient = $this->prophesize(SesClient::class);
        $this->mailer = new AwsSesMailer($this->sesClient->reveal());
    }

    public function testCanSendRenderedMail()
    {
        $renderedMail = new RenderedMail();
        $renderedMail = $renderedMail->withSubject('Hello')
                                     ->withFrom('from@gmail.com')
                                     ->withTo('to@gmail.com')
                                     ->withBcc(['bcc1@gmail.com', 'bcc2@gmail.com'])
                                     ->withCc(['cc1@gmail.com', 'cc2@gmail.com'])
                                     ->withReplyTo('from@gmail.com')
                                     ->withTextBody('Hello world')
                                     ->withHtmlBody('<p>Hello world</p>');

        $result = $this->createAwsResult();

        $this->sesClient->sendEmail(Argument::type('array'))->shouldBeCalled()->willReturn($result);

        $messageId = $this->mailer->send($renderedMail);

        $this->assertEquals('test', $messageId);
    }

    public function testCanSendTemplatedMail()
    {
        $templatedEmail = new TemplatedMail();
        $templatedEmail = $templatedEmail->withTemplate('template-123')
                                         ->withTemplateVariables(['foo' => 'bar'])
                                         ->withFrom('from@gmail.com')
                                         ->withTo('to@gmail.com')
                                         ->withBcc(['bcc1@gmail.com', 'bcc2@gmail.com'])
                                         ->withCc(['cc1@gmail.com', 'cc2@gmail.com']);

        $result = $this->createAwsResult();

        $this->sesClient->sendTemplatedEmail(Argument::type('array'))->shouldBeCalled()->willReturn($result);

        $messageId = $this->mailer->send($templatedEmail);

        $this->assertEquals('test', $messageId);
    }

    private function createAwsResult() : Result
    {
        return new Result(['MessageId' => 'test']);
    }
}

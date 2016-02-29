<?php

namespace ZfrMailTest\Mail;

use ZfrMail\Mail\Attachment;
use ZfrMail\Mail\RenderedMail;

class RenderedMailTest extends \PHPUnit_Framework_TestCase
{
    public function testMail()
    {
        $mail    = new RenderedMail();
        $newMail = $mail->withFrom('from@gmail.com')
            ->withTo('to@gmail.com')
            ->withCc(['cc@gmail.com'])
            ->withBcc(['bcc@gmail.com'])
            ->withReplyTo('reply-to@gmail.com')
            ->withAddedAttachment(new Attachment('content', 'content-type', 'name'))
            ->withSubject('Hello')
            ->withTextBody('Hello world')
            ->withHtmlBody('<p>Hello world</p>');

        $this->assertNotSame($mail, $newMail);

        $this->assertEquals('', $mail->getFrom());
        $this->assertEquals('from@gmail.com', $newMail->getFrom());

        $this->assertEquals('', $mail->getTo());
        $this->assertEquals('to@gmail.com', $newMail->getTo());

        $this->assertEquals([], $mail->getCc());
        $this->assertEquals(['cc@gmail.com'], $newMail->getCc());

        $this->assertEquals([], $mail->getBcc());
        $this->assertEquals(['bcc@gmail.com'], $newMail->getBcc());

        $this->assertEquals('', $mail->getReplyTo());
        $this->assertEquals('reply-to@gmail.com', $newMail->getReplyTo());

        $this->assertCount(0, $mail->getAttachments());
        $this->assertCount(1, $newMail->getAttachments());

        $this->assertEquals('', $mail->getSubject());
        $this->assertEquals('Hello', $newMail->getSubject());

        $this->assertEquals('', $mail->getTextBody());
        $this->assertEquals('Hello world', $newMail->getTextBody());

        $this->assertEquals('', $mail->getHtmlBody());
        $this->assertEquals('<p>Hello world</p>', $newMail->getHtmlBody());
    }
}
<?php

namespace ZfrMailTest\Mail;

use ZfrMail\Mail\Attachment;

class AttachmentTest extends \PHPUnit_Framework_TestCase
{
    public function testAttachment()
    {
        $attachment = new Attachment('content', 'application/text', 'content.txt');

        $this->assertEquals('content', $attachment->getContent());
        $this->assertEquals('application/text', $attachment->getContentType());
        $this->assertEquals('content.txt', $attachment->getName());
    }
}
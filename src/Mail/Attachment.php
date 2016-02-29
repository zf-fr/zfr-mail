<?php

namespace ZfrMail\Mail;

/**
 * @author Michaël Gallego
 */
class Attachment implements AttachmentInterface
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $content
     * @param string $contentType
     * @param string $name
     */
    public function __construct(string $content, string $contentType, string $name)
    {
        $this->content     = $content;
        $this->contentType = $contentType;
        $this->name        = $name;
    }

    /**
     * {@inheritDoc}
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * {@inheritDoc}
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }
}

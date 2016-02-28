<?php

namespace ZfrMail\Mail;

/**
 * @author Michaël Gallego
 */
interface AttachmentInterface
{
    /**
     * Get the content (base64)
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Get the content type of the attachment
     *
     * @return string
     */
    public function getContentType(): string;

    /**
     * Get the file name
     *
     * @return string
     */
    public function getName(): string;
}
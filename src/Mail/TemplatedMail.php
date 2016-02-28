<?php

namespace ZfrMail\Mail;

/**
 * @author Michaël Gallego
 */
class TemplatedMail extends AbstractMail implements TemplatedMailInterface
{
    /**
     * @var string
     */
    private $template = '';

    /**
     * @var array
     */
    private $templateVariables = [];

    /**
     * {@inheritDoc}
     */
    public function withTemplate(string $template): TemplatedMailInterface
    {
        $new = clone $this;
        $new->template = $template;

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * {@inheritDoc}
     */
    public function withTemplateVariables(array $templateVariables): TemplatedMailInterface
    {
        $new = clone $this;
        $new->templateVariables = $templateVariables;

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplateVariables(): array
    {
        return $this->templateVariables;
    }
}

<?php

namespace ZfrMail\Mail;

/**
 * Simple interface around a templated mail
 *
 * Please note that this interface is not used to render your own emails. Instead, it uses a native
 * template system from a mail provider (like Postmark or Mandrill).
 *
 * If you need to render yourself your own emails, you should implement your own mechanism
 *
 * @author Michaël Gallego
 */
interface TemplatedMailInterface extends MailInterface
{
    /**
     * Add a new template identifier
     *
     * @param  string $template
     * @return static
     */
    public function withTemplate(string $template): TemplatedMailInterface;

    /**
     * Get the template identifier
     *
     * @return string
     */
    public function getTemplate(): string;

    /**
     * Add template variables
     *
     * @param  array $templateVariables
     * @return static
     */
    public function withTemplateVariables(array $templateVariables): TemplatedMailInterface;

    /**
     * Get the template varaibles
     *
     * @return array
     */
    public function getTemplateVariables(): array;
}

<?php

namespace ZfrMail\Container;

use Aws\Ses\SesClient;
use Psr\Container\ContainerInterface;
use ZfrMail\Mailer\AwsSesMailer;

/**
 * @author Florent Blaison
 */
class AwsSesMailerFactory
{
    public function __invoke(ContainerInterface $container) : AwsSesMailer
    {
        $sesClient = $container->get(SesClient::class);

        return new AwsSesMailer($sesClient);
    }
}

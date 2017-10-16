<?php

namespace ZfrMail\Container;

use Aws\Sdk;
use Psr\Container\ContainerInterface;
use ZfrMail\Mailer\AwsSesMailer;

/**
 * @author Florent Blaison
 */
class AwsSesMailerFactory
{
    public function __invoke(ContainerInterface $container) : AwsSesMailer
    {
        $awsSdk = $container->get(Sdk::class);

        return new AwsSesMailer($awsSdk->createSes());
    }
}

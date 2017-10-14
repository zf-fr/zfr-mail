<?php

namespace ZfrMail\Container;

use Aws\Ses\SesClient;
use Psr\Container\ContainerInterface;
use ZfrMail\Exception\RuntimeException;

/**
 * @author Florent Blaison
 */
class SesClientFactory
{
    public function __invoke(ContainerInterface $container) : SesClient
    {
        $config = $container->get('config');

        if (! isset($config['zfr_mail']['aws_ses']['credentials'])) {
            throw new RuntimeException(
                "You didn't properly configure AWS SES ZfrMail. Make sure to include the aws configuration"
            );
        }

        return new SesClient($config['zfr_mail']['aws_ses']);
    }
}

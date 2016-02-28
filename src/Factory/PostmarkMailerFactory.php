<?php

namespace ZfrMail\Container;

use GuzzleHttp\Client as HttpClient;
use Interop\Container\ContainerInterface;
use ZfrMail\Exception\RuntimeException;
use ZfrMail\Mailer\PostmarkMailer;

/**
 * @author Michaël Gallego
 */
class PostmarkMailerFactory
{
    /**
     * @param  ContainerInterface $container
     * @return PostmarkMailer
     */
    public function __invoke(ContainerInterface $container): PostmarkMailer
    {
        $config = $container->get('config');

        if (!isset($config['zfr_mail']['postmark']['server_token'])) {
            throw new RuntimeException(
                "You didn't properly configure Postmark ZfrMail. Make sure to include the server token"
            );
        }

        return new PostmarkMailer($config['zfr_mail']['postmark']['server_token'], new HttpClient());
    }
}
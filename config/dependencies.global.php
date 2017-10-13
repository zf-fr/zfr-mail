<?php

use Aws\Ses\SesClient;
use ZfrMail\Container\AwsSesMailerFactory;
use ZfrMail\Container\PostmarkMailerFactory;
use ZfrMail\Container\SesClientFactory;
use ZfrMail\Mailer\AwsSesMailer;
use ZfrMail\Mailer\PostmarkMailer;

return [
    'dependencies' => [
        'factories' => [
            /* Postmark */
            PostmarkMailer::class => PostmarkMailerFactory::class,
            /* Aws SES */
            SesClient::class => SesClientFactory::class,
            AwsSesMailer::class => AwsSesMailerFactory::class,
        ]
    ],
];

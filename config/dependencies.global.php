<?php

use ZfrMail\Container\AwsSesMailerFactory;
use ZfrMail\Container\PostmarkMailerFactory;
use ZfrMail\Mailer\AwsSesMailer;
use ZfrMail\Mailer\PostmarkMailer;

return [
    'dependencies' => [
        'factories' => [
            /* Postmark */
            PostmarkMailer::class => PostmarkMailerFactory::class,
            /* Aws SES */
            AwsSesMailer::class => AwsSesMailerFactory::class,
        ]
    ],
];

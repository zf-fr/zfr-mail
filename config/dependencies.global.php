<?php

use ZfrMail\Container\PostmarkMailerFactory;
use ZfrMail\Mailer\PostmarkMailer;

return [
    'dependencies' => [
        'factories' => [
            PostmarkMailer::class => PostmarkMailerFactory::class
        ]
    ],
];
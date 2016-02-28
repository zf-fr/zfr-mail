<?php

use ZfrMail\Container\PostmarkMailerFactory;
use ZfrMail\Mailer\PostmarkMailer;

return [
    'dependencies' => [
        PostmarkMailer::class => PostmarkMailerFactory::class
    ],
];
ZfrMail
============

[![Build Status](https://travis-ci.org/zf-fr/zfr-mail.svg)](https://travis-ci.org/zf-fr/zfr-mail)

ZfrMail is a lightweight abstraction around common mail API. It provides only a way to send a message (or templated mail if
the provider

## Dependencies

* PHP 7.0+
* Guzzle 6.0+

## Installation

Installation of ZfrMail is only officially supported using Composer:

```sh
php composer.phar require 'zfr/zfr-mail:1.*'
```

## Usage

### Creating a mail

The first thing is to create a mail. Mails are immutable and follow a similar logic to PSR-7 objects. There are
two different kinds of mails in ZfrMail:

* Rendered mails: those are mails that you are rendering yourself, so you set manually the text and HTML body. ZfrMail
does not come with any integration with template engine such as Twig or Plates. It's up to you to render them.
* Templated mails: some providers like Postmark or Mandrill provide a template system where the templates are stored
in the provider. This allows non-technical people to edit the mail, and make maintenance easier. Make sure that the
provider you are using supports templated emails before using it.

For instance, here is how you can create a simple rendered email:

```php
$mail = (new RenderedMail())->withFrom('from@test.com')
    ->withTo('to@test.com')
    ->withSubject('Hello')
    ->withTextBody('This is a mail')
    ->withHtmlBody('<p>This is a mail</p>');
```

And a templated email:

```php
$mail = (new TemplatedMail())->withFrom('from@test.com')
    ->withTo('to@test.com')
    ->withTemplate('templ-1234')
    ->withTemplateVariables(['first_name' => 'Foo']);
```

Mail can also accepts options. Those options are specific to the mail provider you're using. For instance, if
you are using Postmark, the accepted options are (we're following Postmark convention on naming to make it easy):

* `Tag`
* `InlineCss`
* `TrackOpens`
* `Headers`

### Configuring a mailer

For now, ZfrMail provides integration with Postmark and Amazon SES.

#### Postmark
In order to configure Postmark, add the following code to your config:

```php
return [
    'zfr_mail' => [
        'postmark' => [
            'server_token' => 'YOUR_SERVER_TOKEN'
        ]
    ],
];
```
The server token can be found in your Postmark account.

####Amazon SES
In order to configure Amazon SES, add the following code to your config:
```php
return [
    'zfr_mail' => [
        'aws_ses' => [
            'credentials' => [
                'key' => 'YOUR_AWS_KEY',
                'secret' => 'YOUR_AWS_SECRET
            ],
            'region' => 'YOUR_AWS_REGION',
            'version' => 'AWS_VERSION' // most of the time 'latest'
        ],
    ],
];
```

### Using the mailer

You can now inject the `ZfrMail\Mailer\PostmarkMailer` or `ZfrMail\Mailer\AwsSesMailer` class into your services. Those class comes with a single
`send` method. The mailer will automatically either send a templated or rendered mail for you:

```php
$mailer->send($mail);
```

Mailer also returns the message ID of the underlying platform (if supported). This can be useful if you need to
implement features such as open tracking, where you would need to save into your database the message ID of the
mailer:

```php
$messageId = $mailer->send($mail);
```

> ZfrMail is meant to be a lightweight solution with minimal overhead. As a consequence, it does not any validation
to check whether your email addresses are valid, or if you are properly formatting the options according to your
chosen provider.

## To-do

* Add more providers
* Better error support (for now it will throw Guzzle exceptions, but we may create some pre-defined exceptions
in the future and extract those from the Guzzle error)

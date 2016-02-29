<?php

namespace ZfrMailTest\Container;

use Interop\Container\ContainerInterface;
use ZfrMail\Container\PostmarkMailerFactory;
use ZfrMail\Exception\RuntimeException;

class PostmarkMailerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testThrowExceptionIfNoConfig()
    {
        $this->expectException(RuntimeException::class);

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')->shouldBeCalled()->willReturn([]);

        $factory = new PostmarkMailerFactory();

        $factory->__invoke($container->reveal());
    }

    public function testFactory()
    {
        $config = [
            'zfr_mail' => [
                'postmark' => [
                    'server_token' => 'abc'
                ]
            ]
        ];

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')->shouldBeCalled()->willReturn($config);

        $factory = new PostmarkMailerFactory();
        $factory->__invoke($container->reveal());
    }
}
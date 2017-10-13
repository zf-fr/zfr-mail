<?php

namespace ZfrMailTest\Container;

use Psr\Container\ContainerInterface;
use ZfrMail\Container\SesClientFactory;
use ZfrMail\Exception\RuntimeException;

/**
 * @author Florent Blaison
 */
class SesClientFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testThrowExceptionIfNoConfig()
    {
        $this->expectException(RuntimeException::class);

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')->shouldBeCalled()->willReturn([]);

        $factory = new SesClientFactory();

        $factory->__invoke($container->reveal());
    }

    public function testFactory()
    {
        $config = [
            'zfr_mail' => [
                'aws_ses' => [
                    'credentials' => [
                        'key' => 'abc',
                        'secret' => 'abc',
                    ],
                    'region' => 'a_region',
                    'version' => 'latest',
                ],
            ],
        ];

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')->shouldBeCalled()->willReturn($config);

        $factory = new SesClientFactory();
        $factory->__invoke($container->reveal());
    }
}

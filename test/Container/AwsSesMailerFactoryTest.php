<?php

namespace ZfrMailTest\Container;

use Aws\Ses\SesClient;
use Psr\Container\ContainerInterface;
use ZfrMail\Container\AwsSesMailerFactory;

/**
 * @author Florent Blaison
 */
class AwsSesMailerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $sesClient = $this->prophesize(SesClient::class);
        $container->get(SesClient::class)->shouldBeCalled()->willReturn($sesClient);

        $factory = new AwsSesMailerFactory();

        $factory->__invoke($container->reveal());
    }
}

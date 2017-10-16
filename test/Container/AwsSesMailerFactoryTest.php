<?php

namespace ZfrMailTest\Container;

use Aws\Sdk;
use Aws\Ses\SesClient;
use Prophecy\Argument;
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
        $awsSdk = $this->prophesize(Sdk::class);
        $sesClient = $this->prophesize(SesClient::class);
        $awsSdk->createSes(Argument::any())->shouldBeCalled()->willReturn($sesClient);
        $container->get(Sdk::class)->shouldBeCalled()->willReturn($awsSdk);

        $factory = new AwsSesMailerFactory();

        $factory->__invoke($container->reveal());
    }
}

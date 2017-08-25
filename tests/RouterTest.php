<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

use \PHPUnit\Framework\TestCase;
use \neo\core\router\Router;
use \Klein\Klein;

class RouterTest extends TestCase
{

    protected $router;

    protected function setUp()
    {
        // create a controller mock
        $controller_mock = $this->getMockBuilder('\\neo\\core\\controller\\Controller')
            ->setMethods(['foo_action'])
            ->disableOriginalConstructor()
            ->getMock();
        $controller_mock->method('foo_action')
            ->willReturn("Hellowz");
        // create a controller factory mock that returns the controller
        $factory_mock = $this->getMockBuilder('\\neo\\core\\factory\\Factory')
            ->getMock();
        $factory_mock->method('__invoke')
            ->willReturn($controller_mock);
        // create router
        $this->router = new Router(new Klein(), $factory_mock);
    }

    public function testSimpleRequest()
    {
        // map GET /test to Bar::foo()
        $this->router->map('GET', '/test', 'foo_action', 'BarController');

        $this->assertSame("Hellowz", $this->router->dispatch('/test'));
    }

}

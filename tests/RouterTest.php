<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\tests;

use \neo\router\Router;
use \Klein\Klein;

class RouterTest extends \PHPUnit_Framework_TestCase {

    protected $router;

    protected function setUp()
    {
        // create a controller mock
        $controller_mock = $this->getMockBuilder('\\neo\\controller\\Controller')
            ->setMethods(['foo_action'])
            ->disableOriginalConstructor()
            ->getMock();
        $controller_mock->method('foo_action')
            ->willReturn("Hellowz");
        // create a controller factory mock that returns the controller
        $factory_mock = $this->getMockBuilder('\\neo\\factory\\Factory')
            ->getMock();
        $factory_mock->method('make')
            ->willReturn($controller_mock);
        // create router
        $this->router = new Router(new Klein(), $factory_mock);
    }

    public function testSimpleRequest()
    {
        // map GET /test to Bar::foo()
        $this->router->map('GET', '/test', 'foo_action', 'BarController');

        // lel
        $_SERVER['REQUEST_URI'] = '/test';

        $this->expectOutputString("Hellowz");
        $this->router->dispatch();
    }

}

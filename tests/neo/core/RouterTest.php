<?php

/**
 * This file is part of Neo Framework.
 *
 * (c) 2016-2018 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\core\tests;

use \PHPUnit\Framework\TestCase;
use \neo\core\router\Router;
use \neo\core\controller\ProxyControllerFactory;
use \Klein\Klein;
use \Klein\Request;

class RouterTest extends TestCase
{

    protected $router;

    protected $factory;

    protected function setUp()
    {
        // create a controller mock
        $controller_mock = $this->getMockBuilder('\\neo\\core\\controller\\Controller')
                ->setMethods(['fooAction', 'indexAction'])
                ->disableOriginalConstructor()
                ->getMock();
        $controller_mock->method('fooAction')
                ->willReturn("DEKMANTEL");

        // create a controller factory mock that returns the controller
        $this->factory = $this->getMockBuilder('\\neo\\core\\controller\\ControllerFactory')
                ->getMock();
        $this->factory->method('create')
                ->willReturn($controller_mock);

        // create router
        $this->router = new Router(new Klein(), new ProxyControllerFactory());
    }

    public function testSimpleRequest()
    {
        // map GET /test to BarController::fooAction()
        $this->router->map('GET', '/test', 'fooAction', 'BarController');

        $this->expectOutputString("DEKMANTEL");

        $server = $_SERVER;
        $server['REQUEST_URI'] = '/test';
        $server['REQUEST_METHOD'] = 'GET';
        $this->router->dispatch(new Request(
            [], [], [], $server
        ), $this->factory);
    }

    public function testMultiMethods()
    {
        // map GET|POST /test to BarController::fooAction()
        $this->router->map(['GET', 'POST'], '/test', 'fooAction', 'BarController');

        $this->expectOutputString("DEKMANTELDEKMANTEL");

        // get
        $server = $_SERVER;
        $server['REQUEST_URI'] = '/test';
        $server['REQUEST_METHOD'] = 'GET';
        $this->router->dispatch(new Request(
            [], [], [], $server
        ), $this->factory);

        // get
        $server['REQUEST_METHOD'] = 'POST';
        $this->router->dispatch(new Request(
            [], [], [], $server
        ), $this->factory);

        // get
        $server['REQUEST_METHOD'] = 'DELETE';
        $this->router->dispatch(new Request(
            [], [], [], $server
        ), $this->factory);
    }

}

<?php

/**
 * This file is part of Neo Framework.
 *
 * (c) 2016-2019 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\core\tests;

use \PHPUnit\Framework\TestCase;
use \neo\core\Neo;
use \neo\core\controller\DefaultControllerFactory;
use \Klein\Request;

class NeoTest extends TestCase
{

    public function testFactoryNamespaceInjection()
    {
        $this->expectOutputString("Hello");

        $server = $_SERVER;
        $server['REQUEST_URI'] = '/';
        $server['REQUEST_METHOD'] = 'GET';
        $request = new Request([], [], [], $server);

        Neo::create(__DIR__ . '/example')
                ->registerControllerFactory(new DefaultControllerFactory())
                ->run($request);
    }

    public function testDifferentRoutes()
    {
        $this->expectOutputString("Hello");

        $server = $_SERVER;
        $server['REQUEST_URI'] = '/foo';
        $server['REQUEST_METHOD'] = 'GET';
        $request = new Request([], [], [], $server);

        Neo::create(__DIR__ . '/example2')
                ->registerControllerFactory(new DefaultControllerFactory())
                ->run($request);
    }

}

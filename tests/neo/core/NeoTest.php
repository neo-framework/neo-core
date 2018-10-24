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
use \neo\core\Neo;
use \neo\core\controller\DefaultControllerFactory;

class NeoTest extends TestCase
{

    public function testFactoryNamespaceInjection()
    {
        $this->expectOutputString("Hello");

        Neo::create(__DIR__ . '/example')
                ->registerControllerFactory(new DefaultControllerFactory())
                ->run();
    }

}

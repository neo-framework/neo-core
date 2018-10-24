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
use \neo\core\Application;
use \neo\core\router\Router;
use \endobox\BoxFactory;
use \Psr\Log\NullLogger;

class ApplicationTest extends TestCase
{

    public function testTimezone()
    {
        (new Application(
                [
                    'timezone' => 'Europe/Copenhagen',
                    'debug' => true,
                    'app-namespace' => 'awesome'
                ],
                [],
                $this->createMock(Router::class),
                $this->createMock(BoxFactory::class),
                new NullLogger()))->run();
        $this->assertSame('Europe/Copenhagen', \date_default_timezone_get());
    }

}

<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\core\tests;

use \PHPUnit\Framework\TestCase;
use \neo\core\Application;
use \neo\core\router\Router;
use \endobox\BoxFactory;
use \Psr\Log\NullLogger;

class AppTest extends TestCase
{

    public function testTimezone()
    {
        (new Application(
                [
                    'timezone' => 'Europe/Copenhagen',
                    'debug' => true,
                    'app-namespace' => 'awesome'],
                [],
                $this->createMock(Router::class),
                $this->createMock(BoxFactory::class),
                new NullLogger()))->run();
        $this->assertSame('Europe/Copenhagen', \date_default_timezone_get());
    }

}

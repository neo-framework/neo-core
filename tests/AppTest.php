<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\tests;

use \neo\App;

class AppTest extends \PHPUnit_Framework_TestCase
{

    public function testTimezone()
    {
        App::instance(__DIR__ . '/resources/testroot')->run();
        $this->assertSame('Europe/Copenhagen', \date_default_timezone_get());
    }

    public function testInvalidRootdirException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageRegExp('/Root directory .* does not exist/');
        App::instance(__DIR__ . '/resources/doesntexist');
    }

    public function testMissingServicesException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageRegExp('/does not contain .* section/');
        App::instance(__DIR__ . '/resources/missingservicesroot');
    }

}

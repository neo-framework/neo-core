<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\tests;

use \neo\App;

class AppTest extends \PHPUnit_Framework_TestCase {

    protected $app;

    protected function setUp()
    {
        $this->app = App::instance(__DIR__ . '/resources/testroot');
    }

    public function testTimezone()
    {
        $this->app->run();
        $this->assertSame('Europe/Copenhagen', \date_default_timezone_get());
    }

}

<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

use \PHPUnit\Framework\TestCase;
use \neo\core\App;

class AppTest extends TestCase
{

    public function testTimezone()
    {
        App::instance(__DIR__ . '/resources/testroot')->run();
        $this->assertSame('Europe/Copenhagen', date_default_timezone_get());
    }

    public function testInvalidRootdirException()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageRegExp('/Root directory .* does not exist/');
        App::instance(__DIR__ . '/resources/doesntexist');
    }

    public function testMissingServicesException()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageRegExp('/does not contain .* section/');
        App::instance(__DIR__ . '/resources/missingservicesroot');
    }

    public function testDefaultRouteKeys()
    {
        $app = App::instance(__DIR__ . '/resources/defaultrootkeys');
        $r = new ReflectionObject($app);
        $p = $r->getProperty('container');
        $p->setAccessible(true);
        $c = $p->getValue($app);

        $this->assertEquals([
            'method' => 'POST',
            'action' => 'a_action',
            'controller' => 'AController'
        ], $c['config']['routes']['/a']);

        $this->assertEquals([
            'method' => 'GET',
            'action' => 'b_action',
            'controller' => 'BController'
        ], $c['config']['routes']['/b']);

        $this->assertEquals([
            'method' => 'POST',
            'action' => 'index_action',
            'controller' => 'CController'
        ], $c['config']['routes']['/c']);

        $this->assertEquals([
            'method' => 'GET',
            'action' => 'index_action',
            'controller' => 'DController'
        ], $c['config']['routes']['/d']);
    }

    public function testExampleApp()
    {
        $this->expectOutputString("hello");
        App::instance(__DIR__ . '/testapp')->run('/testapp');
    }

    public function testExampleAppWithMultipleRoutes()
    {
        $this->expectOutputString("hihellofoobar");
        App::instance(__DIR__ . '/anothertestapp')->run('/hi');
        App::instance(__DIR__ . '/anothertestapp')->run('/hello');
        App::instance(__DIR__ . '/anothertestapp')->run('/foo');
        App::instance(__DIR__ . '/anothertestapp')->run('/bar');
    }

}

<?php

/*!
 * Neo Framework (https://neo-framework.github.io)
 *
 * Copyright (c) 2016 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\tests;

use \neo\config\FallbackKeyValueConfig;
use \neo\config\INIConfigFile;

class FallbackKeyValueConfigTest extends \PHPUnit_Framework_TestCase {

    protected $c;

    protected function setUp()
    {
        $this->c = new FallbackKeyValueConfig();
        $this->c->add(new INIConfigFile(__DIR__ . '/resources/testconf0.ini'));
        $this->c->add(new INIConfigFile(__DIR__ . '/resources/testconf1.ini'));
        $this->c->add(new INIConfigFile(__DIR__ . '/resources/testconf2.ini'));
        $this->c->add(new INIConfigFile(__DIR__ . '/resources/testconf3.ini'));
        $this->c->add(new INIConfigFile(__DIR__ . '/resources/testconf4.ini'));
    }

    public function testGet()
    {
        $this->assertSame('TTTT', $this->c->get('a', 'foo'));
        $this->assertSame('BBBB', $this->c->get('b', 'foo'));
        $this->assertSame('CCCC', $this->c->get('c', 'foo'));
        $this->assertSame('ZZZZ', $this->c->get('d', 'bar'));
        $this->assertSame('XXXX', $this->c->get('e', 'bar'));
        $this->assertSame('FFFF', $this->c->get('f', 'bar'));
        $this->assertSame('GGGG', $this->c->get('g', 'qux'));
        $this->assertSame('HHHH', $this->c->get('h', 'qux'));
        $this->assertSame('RRRR', $this->c->get('t'));
        $this->assertSame('UUUU', $this->c->get('u'));
        $this->assertSame('SSSS', $this->c->get('v'));
        $this->assertSame('WWWW', $this->c->get('w'));
    }

    public function testToArray()
    {
        $this->assertEquals([
            'foo' => [
                'a' => 'TTTT',
                'b' => 'BBBB',
                'c' => 'CCCC'
            ],
            'bar' => [
                'd' => 'ZZZZ',
                'e' => 'XXXX',
                'f' => 'FFFF'
            ],
            'qux' => [
                'g' => 'GGGG',
                'h' => 'HHHH'
            ],
            't' => 'RRRR',
            'u' => 'UUUU',
            'v' => 'SSSS',
            'w' => 'WWWW'
        ], $this->c->toArray());
    }

}

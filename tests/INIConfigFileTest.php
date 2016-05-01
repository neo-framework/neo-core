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

use \neo\config\INIConfigFile;

class INIConfigFileTest extends \PHPUnit_Framework_TestCase {

    protected $c0;
    protected $c1;
    protected $c2;
    protected $c3;

    protected function setUp()
    {
        $this->c0 = new INIConfigFile(__DIR__ . '/resources/testconf0.ini');
        $this->c1 = new INIConfigFile(__DIR__ . '/resources/testconf1.ini');
        $this->c2 = new INIConfigFile(__DIR__ . '/resources/testconf2.ini');
        $this->c3 = new INIConfigFile(__DIR__ . '/resources/testconf3.ini');
    }

    public function testGetGlobal()
    {
        // get keys from global
        $this->assertSame('TTTT', $this->c3->get('t'));
        $this->assertSame('UUUU', $this->c3->get('u'));
        $this->assertSame('VVVV', $this->c3->get('v'));
        $this->assertSame('WWWW', $this->c3->get('w'));
    }

    public function testGetGlobalDefault()
    {
        // fallback to default if key doesn't exist
        $this->assertSame(null, $this->c3->get('x'));
        $this->assertSame(null, $this->c3->get('a'));
        $this->assertSame("foobar", $this->c3->get('x', null, "foobar"));
        $this->assertSame(42, $this->c3->get('a', null, 42));
    }

    public function testGetSection()
    {
        // get keys from section
        $this->assertSame('AAAA', $this->c0->get('a', 'foo'));
        $this->assertSame('BBBB', $this->c0->get('b', 'foo'));
        $this->assertSame('CCCC', $this->c0->get('c', 'foo'));
        $this->assertSame('DDDD', $this->c0->get('d', 'bar'));
        $this->assertSame('EEEE', $this->c0->get('e', 'bar'));
    }

    public function testGetSectionDefault()
    {
        // fallback to default if key doesn't exist
        $this->assertSame(null, $this->c0->get('j', 'bar'));
        $this->assertSame(null, $this->c0->get('e', 'qux'));
        $this->assertSame(null, $this->c0->get('r', 'baz'));
        $this->assertSame("foobar", $this->c0->get('j', 'bar', "foobar"));
        $this->assertSame(42, $this->c0->get('e', 'qux', 42));
        $this->assertSame(1337, $this->c0->get('r', 'baz', 1337));
    }

    public function testToArray()
    {
        $this->assertEquals([
            'foo' => [
                'a' => 'AAAA',
                'b' => 'BBBB',
                'c' => 'CCCC'
            ],
            'bar' => [
                'd' => 'DDDD',
                'e' => 'EEEE'
            ]
        ], $this->c0->toArray());

        $this->assertEquals([
            'bar' => [
                'd' => 'ZZZZ',
                'e' => 'YYYY',
                'f' => 'FFFF'
            ]
        ], $this->c1->toArray());

        $this->assertEquals([
            'qux' => [
                'g' => 'GGGG',
                'h' => 'HHHH'
            ],
            'bar' => [
                'e' => 'XXXX'
            ],
            'foo' => [
                'a' => 'TTTT'
            ]
        ], $this->c2->toArray());

        $this->assertEquals([
            't' => 'TTTT',
            'u' => 'UUUU',
            'v' => 'VVVV',
            'w' => 'WWWW'
        ], $this->c3->toArray());
    }

}

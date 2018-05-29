<?php

/**
 * This file is part of Neo Framework.
 *
 * (c) 2016-2018 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\core;

use \neo\core\router\Router;
use \Psr\Log\NullLogger;

/**
 *
 */
final class Neo
{

    /**
     *
     */
    public static function create(string $root) : Application
    {
        // TODO fill router with routes from config files
        // TODO read config and decide which logger to use
        return new Application(
                Configuration::createFromFile($root . '/config/neo.json'),
                new Router(),
                new NullLogger());
    }

    private function __construct()
    {
    }

}

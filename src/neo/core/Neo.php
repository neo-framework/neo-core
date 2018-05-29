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
        return new Application($root, new Router());
    }

    private function __construct()
    {
    }

}

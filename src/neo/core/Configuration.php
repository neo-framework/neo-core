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

/**
 * Application configuration.
 */
class Configuration
{

    public static function createFromFile(string $path) : Configuration
    {
        // TODO parse json file
    }

    public function __construct(array $config)
    {
        // TODO
    }

    public function get(string $key)
    {
        // TODO
    }

    public function set(string $key, $value)
    {
        // TODO
    }

}

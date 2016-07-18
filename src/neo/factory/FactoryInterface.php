<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\factory;

/**
 * Factory interface.
 */
interface FactoryInterface
{

    /**
     * Return the requested instance.
     */
    public function factor($classname, array $args = null);

}

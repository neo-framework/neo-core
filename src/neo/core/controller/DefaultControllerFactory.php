<?php

/**
 * This file is part of Neo Framework.
 *
 * (c) 2016-2018 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\core\controller;

/**
 * Factory that creates {@link Controller} objects using default constructor (no arguments).
 */
class DefaultControllerFactory extends ControllerFactory
{

    /**
     * Create a {@link Controller} instance using a default constructor (no arguments).
     */
    public function create(string $type) : ?Controller
    {
        $ref = new \ReflectionClass($type);
        $ctor = $ref->getConstructor();
        if ($ctor && $ctor->getNumberOfParameters() === 0) {

            return $type();

        }

        return $this->fallthrough($type);
    }

}

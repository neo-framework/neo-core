<?php

/**
 * This file is part of Neo Framework.
 *
 * (c) 2016-2019 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\core\controller;

/**
 * Factory that creates {@link Controller} objects using the given list of Factories
 * until one of them returns a non-null value.
 */
class MultiControllerFactory extends ControllerFactory
{

    private $factories;

    /**
     *
     */
    public function __construct(ControllerFactory ...$factories)
    {
        $this->factories = $factories;
    }

    /**
     *
     */
    public function create(string $type) : ?Controller
    {
        foreach ($this->factories as &$fac) {
            $closed = $fac->isClosed();
            $fac->open();
            $controller = $fac->create($type);
            if ($closed) $fac->close();
            if ($controller !== null) return $controller;
        }

        return $this->fallthrough($type);
    }

}

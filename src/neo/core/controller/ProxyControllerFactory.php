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
 * Factory proxy that serves as a placeholder and delegates to a concrete Factory at a later point.
 */
class ProxyControllerFactory extends ControllerFactory
{

    private $factory = null;

    /**
     * Replace proxy with actual Factory.
     */
    public function replace(ControllerFactory $actual_factory)
    {
        $this->factory = $actual_factory;
        
        return $this;
    }

    public function create(string $type) : ?Controller
    {
        if ($this->factory !== null) {
            return $this->factory->create($type);
        }

        return $this->fallthrough($type);
    }

    public function close()
    {
        if ($this->factory !== null) {
            $this->factory->close();
        }

        $this->closed = true;

        return $this;
    }

    public function open()
    {
        if ($this->factory !== null) {
            $this->factory->open();
        }

        $this->closed = false;

        return $this;
    }

    public function isClosed() : boolean
    {
        if ($this->factory !== null) {
            return $this->factory->isClosed();
        }

        return $this->closed;
    }

}

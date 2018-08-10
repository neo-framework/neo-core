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
 * Decorator pattern.
 */
abstract class ControllerFactoryDecorator extends ControllerFactory
{

    private $factory;

    public function __construct(ControllerFactory $factory)
    {
        $this->factory = $factory;
    }

    public function create(string $type) : ?Controller
    {
        return $this->factory->create($type);
    }

}

<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\core\factory;

use \Pimple\Container;

abstract class ContainerAwareFactory implements Factory
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public abstract function __invoke(string $classname, array $args = []);

}

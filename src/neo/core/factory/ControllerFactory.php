<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\core\factory;

use \Klein\Request;
use \Klein\Response;

/**
 * This is the class that knows how controllers are constructed.
 */
class ControllerFactory extends ContainerAwareFactory
{

    public function __invoke(string $classname, array $args = [])
    {
        $classname = $this->container['config']['global']['app_ns'] . '\\controllers\\' . $classname;

        if (!\class_exists($classname)) {
            throw new \RuntimeException(\sprintf(
                    'Could not instantiate controller: Class "%s" does not exist.', $classname));
        }

        if (!(isset($args[0]) && $args[0] instanceof Request)) {
            throw new \RuntimeException('Could not instantiate controller: Expected args[0] to be of type Request.');
        }

        if (!(isset($args[1]) && $args[1] instanceof Response)) {
            throw new \RuntimeException('Could not instantiate controller: Expected args[1] to be of type Response.');
        }

        return new $classname(
                $args[0],
                $args[1],
                $this->container['endobox'],
                $this->container['model_factory'],
                $this->container['controller_plugin_factory']);
    }

}

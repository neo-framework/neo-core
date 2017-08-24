<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\core\factory;

use \neo\core\controller\Controller;
use \neo\core\factory\ControllerFactory;

/**
 * This is the class that knows how controller plug-ins are constructed.
 */
class ControllerPluginFactory extends ContainerAwareFactory
{

    public function __invoke(string $plugin, array $args = [])
    {
        if (isset($this->container['config']['plugins'][$plugin])) {
            $classname = $this->container['config']['plugins'][$plugin];
        } else {
            $classname = $this->container['config']['global']['app_ns'] . '\\plugins\\controller\\'
                    . \str_replace('_', '', \ucwords($plugin, '_')) . 'Plugin';
        }

        if (!\class_exists($classname)) {
            throw new \RuntimeException(\sprintf(
                    'Could not instantiate controller plug-in: Class "%s" does not exist.', $classname));
        }

        if (!(isset($args[0]) && $args[0] instanceof Controller)) {
            throw new \RuntimeException(
                    'Could not instantiate controller plug-in: Expected args[0] to be of type Controller.');
        }

        return new $classname(
                $args[0],
                $this->container['controller_factory']);
    }

}

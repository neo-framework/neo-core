<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\core\factory;

/**
 * This is the class that knows how models are constructed.
 */
class ModelFactory extends ContainerAwareFactory
{

    public function __invoke(string $classname, array $args = [])
    {
        $classname = $this->container['config']['global']['app_ns'] . '\\models\\' . $classname;

        if (!\class_exists($classname)) {
            throw new \RuntimeException(\sprintf(
                    'Could not instantiate model: Class "%s" does not exist.', $classname));
        }

        return new $classname($this->container['database_connection']);
    }

}

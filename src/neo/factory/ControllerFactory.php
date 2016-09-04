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
 * Controller factory.
 */
class ControllerFactory implements Factory
{

    public function make(string $classname, array $args = null)
    {
        if (!\class_exists($classname)) {
            throw new \RuntimeException(\sprintf(
                'Could not instantiate controller: Class "%s" does not exist.', $classname));
        }

        if (!isset($args[0])) {
            throw new \RuntimeException('Could not instantiate controller: Missing request argument.');
        }

        return new $classname($args[0]);
    }

}

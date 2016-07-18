<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\factory;

use \neo\exception\CoreException;

/**
 * Controller factory.
 */
class ControllerFactory implements FactoryInterface
{

    public function factor($classname, array $args = null)
    {
        if (!class_exists($classname)) {
            throw new CoreException(sprintf('Could not instantiate controller: Class %s does not exist.', $classname));
        }

        if (!isset($args[0])) {
            throw new CoreException('Could not instantiate controller: Missing request argument.');
        }
        $request = $args[0];

        $c = new $classname($request);

        return $c;
    }

}

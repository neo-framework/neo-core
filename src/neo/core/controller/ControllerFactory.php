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
 * Abstract Factory that creates {@link Controller} objects.
 *
 * By implementing and registering this Factory you can inform Neo how your Controllers shall be created at runtime.
 */
interface ControllerFactory
{

    /**
     * Create a {@link Controller} instance.
     *
     * @param string $type Fully qualified class name of the {@link Controller}.
     * @return Controller The freshly created {@link Controller} instance.
     */
    public function create(string $type) : Controller;

}

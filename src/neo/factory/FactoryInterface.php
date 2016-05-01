<?php

/*!
 * Neo Framework (https://neo-framework.github.io)
 *
 * Copyright (c) 2016 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\factory;

/*!
 * Factory interface.
 */
interface FactoryInterface {

    /*!
     * Return the requested instance.
     */
    public function factor($classname, array $args = null);

}

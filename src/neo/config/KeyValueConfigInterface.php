<?php

/*!
 * Neo Framework (https://neo-framework.github.io)
 *
 * Copyright (c) 2016 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\config;

/*!
 * A key-value config with optional sections and default value.
 */
interface KeyValueConfigInterface {

    /*!
     * Get value by key.
     *
     * If section is specified then look inside the section.
     * If the config does not contain a given key then default should be returned.
     */
    public function get($key, $section = null, $default = null);

    /*!
     * Return an associative array that contains everything.
     *
     * If section is specified then only that specific section is returned.
     */
    public function toArray($section = null);

}

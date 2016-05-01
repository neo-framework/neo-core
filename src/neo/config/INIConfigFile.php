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

use \neo\exception\CoreException;

/*!
 * A single INI config file.
 */
class INIConfigFile implements KeyValueConfigInterface {

    private $path;

    private $data = null;

    public function __construct($path)
    {
        if (\file_exists($path) === false) {
            throw new CoreException(\sprintf("Config file (%s) does not exist.", $path));
        }
        $this->path = $path;
    }

    public function get($key, $section = null, $default = null)
    {
        // lazy loading
        if ($this->data === null) {
            if (($data = \parse_ini_file($this->path, true)) === false) {
                throw new CoreException(\sprintf("Failed to parse config file (%s).", $this->path));
            }
            $this->data = $data;
        }
        if ($section === null) {
            return isset($this->data[$key]) ? $this->data[$key] : $default;
        }
        return isset($this->data[$section][$key]) ? $this->data[$section][$key] : $default;
    }

    public function toArray($section = null)
    {
        // lazy loading
        if ($this->data === null) {
            if (($data = \parse_ini_file($this->path, true)) === false) {
                throw new CoreException(\sprintf("Failed to parse config file (%s).", $this->path));
            }
            $this->data = $data;
        }
        if ($section === null) {
            return $this->data;
        }
        return isset($this->data[$section]) ? $this->data[$section] : [];
    }

}

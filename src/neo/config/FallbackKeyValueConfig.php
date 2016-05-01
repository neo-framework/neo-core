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
 * A key-value configuration that implements a fallback mechanism.
 *
 * The idea is that we keep track of a list of available configs so get() will iterate over this list
 * and when the first config does not contain the key, we fallback to the second one and so forth.
 */
class FallbackKeyValueConfig implements KeyValueConfigInterface {

    private $configs = [];

    public function __construct(KeyValueConfigInterface $c = null)
    {
        $this->add($c);
    }

    /*!
     * Add a config to the list.
     * The added config has the highest priority (i.e., get() will look at it first).
     */
    public function add(KeyValueConfigInterface $c = null)
    {
        $c !== null && \array_unshift($this->configs, $c);
    }

    public function get($key, $section = null, $default = null)
    {
        foreach ($this->configs as $c) {
            if (($result = $c->get($key, $section)) !== null) {
                return $result;
            }
        }
        return $default;
    }

    public function toArray($section = null)
    {
        $arrays = [];
        foreach ($this->configs as $c) {
            \array_unshift($arrays, $c->toArray($section));
        }
        if ($section === null) {
            $result = [];
            $global = [];
            foreach ($arrays as $a) {
                foreach ($a as $section => $value) {
                    if (\is_array($value)) {
                        $result[$section][] = $value;
                    } else {
                        $global[$section] = $value;
                    }
                }
            }
            foreach ($result as $section => $values) {
                $result[$section] = \call_user_func_array('\array_merge', $values);
            }
            // sections override global keys
            return \array_merge($global, $result);
        }
        return \call_user_func_array('\array_merge', $arrays);
    }

}

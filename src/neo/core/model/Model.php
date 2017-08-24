<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\core\model;

abstract class Model
{

    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

}

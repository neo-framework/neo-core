<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\controller;

use \Klein\Request;

abstract class Controller
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

}

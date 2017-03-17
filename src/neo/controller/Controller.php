<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\controller;

use \Klein\Request;
use \Klein\Response;
use \endobox\Factory as Endobox;

abstract class Controller
{

    protected $request;

    protected $response;

    protected $view;

    public function __construct(Request $request, Response $response, Endobox $endobox)
    {
        $this->request = $request;
        $this->response = $response;
        $this->view = $endobox;
    }

}

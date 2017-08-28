<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\core\controller;

use \neo\core\factory\ControllerFactory;
use \neo\core\router\Router;
use \neo\core\router\Request;
use \neo\core\router\Response;

abstract class Plugin
{

    protected $controller;

    protected $controller_factory;

    protected $router;

    protected $request;

    protected $response;

    public function __construct(
            Controller $c,
            ControllerFactory $cf,
            Router $r,
            Request $req,
            Response $resp)
    {
        $this->controller = $c;
        $this->controller_factory = $cf;
        $this->router = $r;
        $this->request = $req;
        $this->response = $resp;

        $this->on_load();
    }

    protected function on_load()
    {
        //
    }

}

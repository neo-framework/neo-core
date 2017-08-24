<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\core\controller;

abstract class Plugin
{

    protected $controller;

    protected $controller_factory;

    public function __construct(Controller $c, ControllerFactory $cf)
    {
        $this->controller = $c;
        $this->controller_factory = $cf;

        $this->on_load();
    }

    protected function on_load()
    {
        //
    }

}

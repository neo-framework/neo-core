<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\router;

use \Klein\Klein;
use \neo\factory\FactoryInterface as Factory;
use \neo\exception\CoreException;

/**
 * The Router forwards queries to the right controller.
 * Here, we are using Klein as a backend to handle the routing.
 */
class Router
{

    private $klein;

    private $controller_factory;

    public function __construct(Klein $klein, Factory $controller_factory)
    {
        $this->klein = $klein;
        $this->controller_factory = $controller_factory;
    }

    /**
     * Find a matching route for the request and run it.
     */
    public function dispatch()
    {
        $this->klein->onHttpError(function ($code) {
            throw new CoreException('HTTP Error ' . $code);
        });
        $this->klein->dispatch();
    }

    /**
     * Map an http method and route to an action and controller.
     */
    public function map($method, $route, $action, $controller)
    {
        $cf = $this->controller_factory;

        $this->klein->respond($method, $route, function ($request) use ($cf, $action, $controller) {
            $controller .= 'Controller';
            $action .= '_action';
            $c = $cf->factor($controller, [$request]);
            return $c->$action();
        });
    }

}
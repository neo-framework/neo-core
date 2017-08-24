<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\core\router;

use \Klein\Klein;
use \Klein\Request;
use \neo\core\factory\Factory;

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
    public function dispatch(string $request = null)
    {
        if ($request !== null) {
            $server = $_SERVER;
            $server['REQUEST_URI'] = $request;
            $this->klein->dispatch(new Request($_GET, $_POST, $_COOKIE, $server, $_FILES));
        } else {
            $this->klein->dispatch();
        }
    }

    /**
     * Map an http method and route to an action and controller.
     */
    public function map(string $method, string $route, string $action, string $controller)
    {
        // alias
        $cf = $this->controller_factory;

        $this->klein->respond($method, $route, function ($request, $response) use (&$cf, $action, $controller) {

            return $cf($controller, [ $request, $response ])->$action();

        });
    }

}

<?php

/*!
 * Neo Framework (https://neo-framework.github.io)
 *
 * Copyright (c) 2016 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\router;

use \Klein\Klein;
use \neo\factory\FactoryInterface;
use \neo\exception\CoreException;

/*!
 * The Router forwards queries to the right controller.
 */
class Router {

    private $klein;

    private $controller_factory;

    /*!
     * klein: Instance of Klein router
     *
     * routes: Key-value config array containing all routes
     *
     * controller_factory: Controller factory used to create controller objects on demand
     */
    public function __construct(Klein $klein, array $routes, FactoryInterface $controller_factory)
    {
        $this->klein = $klein;
        $this->controller_factory = $controller_factory;
        $this->map($routes);
    }

    /*!
     * Find a matching route for the request and run it.
     */
    public function dispatch()
    {
        $this->klein->onHttpError(function ($code) {
            die("<h1>Error $code</h1>");
        });
        $this->klein->dispatch();
    }

    /*!
     * Map each route to a callable that will initiate the controller.
     */
    private function map($routes)
    {
        $controller_factory = $this->controller_factory;

        foreach ($routes as $route => $target) {
            // split into http methods and controller
            $target = \explode(' ', $target);
            if (\count($target) !== 2) {
                throw new CoreException("Could not split HTTP methods and Controller: Invalid route syntax.");
            }

            // extract http methods
            $method = \array_values(\array_intersect(\explode('|', $target[0]),
                ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS']));
            if (\count($method) === 0) {
                throw new CoreException("Could not extract HTTP methods: Invalid route syntax.");
            }

            // split controller into class and function
            $controller = \explode('@', $target[1]);
            if (\count($controller) !== 2) {
                throw new CoreException("Could not split Controller into class and function: Invalid route syntax.");
            }

            // replace angular brackets by square brackets
            $route = \str_replace('<', '[', $route);
            $route = \str_replace('>', ']', $route);

            $dispatch = $controller[0];
            $controller = $controller[1];

            // register route to klein
            $this->klein->respond($method, $route,
                function ($request) use ($controller_factory, $dispatch, $controller) {
                    $c = $controller_factory->factor($controller);
                    $c->setRequest($request);
                    return $c->$dispatch();
                });
        }
    }

}

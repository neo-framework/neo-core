<?php

/**
 * This file is part of Neo Framework.
 *
 * (c) 2016-2019 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\core\router;

use \neo\core\controller\ControllerFactory;
use \neo\core\controller\ProxyControllerFactory;
use \Klein\Klein;
use \Klein\Request;

/**
 *
 */
class Router
{

    private $klein;

    private $proxy_factory;

    public function __construct(Klein $klein, ProxyControllerFactory $proxy_factory)
    {
        $this->klein = $klein;
        $this->proxy_factory = $proxy_factory;
    }

    /**
     * Map HTTP method and route to some action and controller.
     *
     * @param mixed $method Uppercase HTTP method string or array of multiple methods.
     * @param string $route Concrete route or route pattern.
     * @param string $action Name of the action method that shall be called if route gets matched.
     * @param string $controller Fully qualified class name of the {@link Controller} that shall be invoked.
     */
    public function map($method, string $route, string $action, string $controller)
    {
        // alias
        $proxy = $this->proxy_factory;

        if (!\is_array($method)) {
            $method = [(string)$method];
        }

        // TODO assert whitelist methods

        foreach ($method as $m) {
            $this->klein->respond($m, $route, function ($request, $response) use (&$proxy, $action, $controller) {

                return $proxy($controller)
                        ->setRequest($request)
                        ->setResponse($response)
                        ->$action();

            });
        }

        return $this;
    }

    /**
     *
     */
    public function dispatch(Request $request, ControllerFactory $actual_factory)
    {
        $this->proxy_factory
                ->replace($actual_factory)
                ->close();

        return $this->klein->dispatch($request);
    }

}

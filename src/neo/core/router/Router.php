<?php

/**
 * This file is part of Neo Framework.
 *
 * (c) 2016-2018 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\core\router;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FastRoute\Dispatcher;

/**
 *
 */
class Router
{

    private $fastroute;

    public function __construct(Dispatcher $fastroute)
    {
        $this->fastroute = $fastroute;
    }

    /**
     *
     */
    public function dispatch(Request $request)
    {
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
    }

}

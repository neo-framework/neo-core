<?php

/**
 * This file is part of Neo Framework.
 *
 * (c) 2016-2018 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\core;

use \neo\core\router\Router;
use \Psr\Log\LoggerInterface as Logger;

/**
 * Neo Application.
 */
class Application
{

    private $root;

    private $router;

    private $logger;

    private $controller_factories;

    /**
     * Construct an Application inside the given root directory.
     *
     * @param string $root Root directory of the application.
     * @param Router $router Instance of Neo's awesome router.
     */
    public function __construct(string $root, Router $router, Logger $logger)
    {
        $this->root = $root;
        $this->router = $router;
        $this->logger = $logger;
        $this->$controller_factories = [];
    }

    /**
     * Entry point for Neo.
     */
    public function run()
    {
        try {
            $this->router->dispatch(Request::createFromGlobals());
        } catch (\Exception $e) {

        }
    }

    /**
     * Register a Controller Factory.
     */
    public function registerControllerFactory(ControllerFactory $cf)
    {
        $this->$controller_factories[] = $cf;
    }

}
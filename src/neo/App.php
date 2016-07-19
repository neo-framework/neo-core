<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo;

use \Pimple\Container;
use \neo\exception\CoreException;

class App
{

    private $rootdir;

    private $container;

    private $router;

    public static function get($rootdir)
    {
        return new static($rootdir, new Container());
    }

    public function __construct($rootdir, Container $container)
    {
        if (!file_exists($rootdir)) {
            throw new \InvalidArgumentException(sprintf('Root directory (%s) does not exist.', $rootdir));
        }
        $this->rootdir = $rootdir;

        $this->container = $container;

        // create container instance and register services
        if (!file_exists($services_config_file = $this->rootdir . '/config/services.config.php')) {
            throw new \InvalidArgumentException(
                sprintf('Services config file (%s) does not exist.', $services_config_file));
        }
        $services = require $services_config_file;
        foreach ($services['services'] as $serv => $closure) {
            $this->container[$serv] = $closure;
        }

        // get router instance and register routes
        $this->router = $this->container['neo/router'];
        foreach ($this->container['config']['routes'] as $r => $x) {
            $this->router->map($x['method'], $r, $x['action'], $x['controller']);
        }
    }

    public function run()
    {
        $config = $this->container['config'];

        $debug = (bool)$config['global']['debug'];
        error_reporting($debug ? -1 : 0);

        date_default_timezone_set($config['global']['timezone']);

        try {
            try {

                echo $this->router->dispatch();

            } catch (\Klein\Exceptions\UnhandledException $e) {
                throw new CoreException($e->getMessage());
            }
        } catch (CoreException $e) {
            $debug && die(sprintf('<h1>Exception</h1><p>%s</p>', $e->getMessage()));
        }
    }

}

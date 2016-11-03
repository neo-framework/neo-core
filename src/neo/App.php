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

class App
{

    private $rootdir;

    private $container;

    private $router;

    public static function instance(string $rootdir) : App
    {
        return new static($rootdir, new Container());
    }

    public function __construct(string $rootdir, Container $container)
    {
        if (!\file_exists($rootdir)) {
            throw new \RuntimeException(\sprintf('Root directory "%s" does not exist.', $rootdir));
        }
        $this->rootdir = $rootdir;

        $this->container = $container;

        // register services
        if (!\file_exists($services_config_file = $this->rootdir . '/config/services.config.php')) {
            throw new \RuntimeException(\sprintf('Services config file "%s" does not exist.', $services_config_file));
        }
        $services = require $services_config_file;
        if (!isset($services['services'])) {
            throw new \RuntimeException('Services config file does not contain "services" section.');
        }
        foreach ($services['services'] as $serv => $closure) {
            $this->container[$serv] = $closure;
        }

        // get router instance and register routes
        if (!isset($this->container['neo/router'])) {
            throw new \RuntimeException('Service "neo/router" not registered.');
        }
        $this->router = $this->container['neo/router'];
        foreach ($this->container['config']['routes'] as $r => &$x) {
            $this->router->map($x['method'], $r, $x['action'], $x['controller']);
        }
    }

    public function run()
    {
        if (!isset($this->container['config'])) {
            throw new \RuntimeException('Service "config" not registered.');
        }
        $config = $this->container['config'];

        $debug = (bool)$config['global']['debug'];
        \error_reporting($debug ? -1 : 0);

        \date_default_timezone_set($config['global']['timezone']);

        try {
            try {

                echo $this->router->dispatch();

            } catch (\Klein\Exceptions\UnhandledException $e) {
                throw new \RuntimeException($e->getMessage());
            }
        } catch (\Exception $e) {
            $debug && die(\sprintf('<h1>Exception</h1><p>%s</p>', $e->getMessage())) || die();
        }
    }

}

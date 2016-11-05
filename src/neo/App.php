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

    private $config;

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

        // register default services
        if (!\file_exists($services_config_file = __DIR__ . '/config/services.config.php')) {
            throw new \RuntimeException(
                \sprintf('Default services config file "%s" does not exist.', $services_config_file));
        }
        $default_services = require $services_config_file;
        if (!isset($default_services['services'])) {
            throw new \RuntimeException('Default services config file does not contain "services" section.');
        }
        foreach ($default_services['services'] as $serv => $closure) {
            $this->container[$serv] = $closure;
        }

        // register user-land services (if any)
        if (!\file_exists($userland_services_file = $this->rootdir . '/config/services.config.php')) {
            throw new \RuntimeException(
                \sprintf('User-land services config file "%s" does not exist.', $userland_services_file));
        }
        $userland_services = require $userland_services_file;
        if (!isset($userland_services['services'])) {
            throw new \RuntimeException('User-land services config file does not contain "services" section.');
        }
        foreach ($userland_services['services'] as $serv => $closure) {
            $this->container[$serv] = $closure;
        }

        // require mandatory services
        $this->require_services([ 'router', 'config' ]);

        // container shortcuts
        $this->router = $this->container['router'];
        $this->config = $this->container['config'];
        
        // register routes
        foreach ($this->config['routes'] as $r => $x) {
            $this->router->map($x['method'], $r, $x['action'], $x['controller']);
        }
    }

    public function run()
    {
        $debug = (bool)$this->config['global']['debug'];
        \error_reporting($debug ? -1 : 0);
        \date_default_timezone_set($this->config['global']['timezone']);

        try {
            try {

                echo $this->router->dispatch();

            } catch (\Klein\Exceptions\UnhandledException $e) {
                throw new \RuntimeException($e->getMessage());
            }
        } catch (\Exception $e) {
            $debug && die(static::format_exception($e)) || die();
        }
    }

    public static function format_exception(\Exception $e)
    {
        $format = <<<'EOT'
<body style='background:#000;color:#d9f097;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;'>
<h1>%s</h1>
<p><strong>%s</strong></p>
<pre>%s</pre>
<p>Neo Framework</p>
</body>
EOT;
        return \sprintf($format, \get_class($e), $e->getMessage(), $e->getTraceAsString());
    }

    private function require_services(array $services)
    {
        foreach ($services as $s) {
            if (!isset($this->container[$s])) {
                throw new \RuntimeException(\sprintf('Service "%s" not registered.', $s));
            }
        }
    }

}

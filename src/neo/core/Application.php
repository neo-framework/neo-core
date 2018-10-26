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
use \neo\core\controller\Controller;
use \neo\core\controller\ControllerFactory;
use \neo\core\controller\MultiControllerFactory;
use \neo\core\controller\ControllerFactoryDecorator;
use \Psr\Log\LoggerInterface as Logger;
use \Klein\Request;
use \endobox\BoxFactory;

/**
 * Neo Application.
 */
class Application
{

    private $config;

    private $routes;

    private $router;

    private $logger;

    private $endobox;

    private $controller_factories = [];

    /**
     * Construct an Application based on a given configuration.
     *
     * @param array $config Global application configuration.
     * @param array $routes Map of defined routes.
     * @param Router $router Instance of Neo's awesome router.
     * @param BoxFactory $endobox Endobox template engine.
     * @param Logger $logger Logger to be used throughout the whole application.
     */
    public function __construct(
            array $config,
            array $routes,
            Router $router,
            BoxFactory $endobox,
            Logger $logger)
    {
        $this->config = $config;
        $this->routes = $routes;
        $this->router = $router;
        $this->endobox = $endobox;
        $this->logger = $logger;
    }

    /**
     * Entry point for Neo.
     */
    public function run(Request $request = null)
    {
        \ini_set('display_errors', $this->config['debug'] ? 1 : 0);
        \ini_set('display_startup_errors', $this->config['debug'] ? 1 : 0);

        \date_default_timezone_set($this->config['timezone']);

        // map all routes
        foreach ($this->routes as $r => &$x) {
            if (isset($x['controller'])) {

                $this->router->map($x['method'], $r, $x['action'], $x['controller']);

            } else foreach ($x as &$xx) {

                $this->router->map($xx['method'], $r, $xx['action'], $xx['controller']);

            }
        }


        // dispatch
        try {
            try {

                $this->router->dispatch(
                        $request === null ? Request::createFromGlobals() : $request,
                        new class(
                                (new MultiControllerFactory(...$this->controller_factories))->close(),
                                $this->endobox,
                                $this->logger,
                                $this->config['app-namespace']) extends ControllerFactoryDecorator {

                            private $endobox;
                            private $logger;
                            private $namespace;

                            public function __construct(
                                    ControllerFactory $factory,
                                    BoxFactory $endobox,
                                    Logger $logger,
                                    string $namespace) {

                                parent::__construct($factory);
                                $this->endobox = $endobox;
                                $this->logger = $logger;
                                $this->namespace = $namespace;
                            }

                            public function create(string $type) : ?Controller {
                                return parent::create('\\' . $this->namespace . '\\controllers\\' . $type)
                                        ->setBoxFactory($this->endobox)
                                        ->setLogger($this->logger);
                            }

                        });

            } catch (\Klein\Exceptions\UnhandledException $e) {
                // TODO fix this mess with the stack trace being part of the message
                throw new \RuntimeException(\sprintf("%s: %s\n<pre>%s</pre>",
                        \get_class($e), $e->getMessage(), $e->getTraceAsString()), $e->getCode(), $e);
            }
        } catch (\Exception $e) {
            if ($this->config['catch-exceptions'] === false) {
                throw $e;
            }

            if ($this->config['debug'] === true) {
                die(self::formatException($e));
            }
            die();
        }

        return $this;
    }

    /**
     * Register a Controller Factory.
     * If multiple Factories get registered, Neo will try them one by one in reverse registration order
     * until one of them returns a non-null value.
     */
    public function registerControllerFactory(ControllerFactory $cf)
    {
        \array_unshift($this->controller_factories, $cf);

        return $this;
    }

    private static function formatException(\Exception $e)
    {
        $format = <<<'EOT'
<body style='background:#171e26;color:#d9f097;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;'>
<h1>%s</h1>
<p><strong>%s</strong></p>
<pre>%s</pre>
<p>Neo Framework</p>
</body>
EOT;
        return \sprintf($format, \get_class($e), $e->getMessage(), $e->getTraceAsString());
    }

}

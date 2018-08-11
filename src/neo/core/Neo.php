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
use \neo\core\controller\ProxyControllerFactory;
use \Psr\Log\NullLogger;
use \Klein\Klein;
use \endobox\Endobox;

/**
 * Facade for {@link Application} with sensible default values.
 */
final class Neo
{

    /**
     * Create a fresh {@link Application} from config file.
     * @param string $root Path to root directory which should contain the "config" folder.
     */
    public static function create(string $root) : Application
    {
        $config = require $root . '/config/neo.config.php';
        $config['root'] = $root;
        
        $routes = require $root . '/config/routes.config.php';


        // TODO read config and decide which logger to use
        // TODO check if paths exist
        return new Application(
                $config,
                $routes,
                new Router(new Klein(), new ProxyControllerFactory()),
                Endobox::create(\sprintf('%s/src/%s/views', $root, $config['app-namespace'])),
                new NullLogger());
    }

    private function __construct()
    {
    }

}

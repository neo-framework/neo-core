<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

return [
    'services' => [

        'controller_plugin_factory' => function ($c) {
            return new neo\core\factory\ControllerPluginFactory($c);
        },

        'config' => function ($c) {
            // read default config
            $config = [];
            foreach (new DirectoryIterator(__DIR__) as $f) {
                if ($f->isFile() && $f->getExtension() === 'php' && $f->getFilename() !== 'services.config.php') {
                    $cfg = require $f->getPathname();
                    $config = array_merge($config, $cfg);
                }
            }

            // read userland config
            $userconfig = [];
            foreach (new DirectoryIterator($c['root_dir'] . '/config') as $f) {
                if ($f->isFile() && $f->getExtension() === 'php' && $f->getFilename() !== 'services.config.php') {
                    $cfg = require $f->getPathname();
                    $userconfig = array_merge($userconfig, $cfg);
                }
            }

            // merge configs
            foreach ($userconfig as $k => $v) {
                if (!isset($config[$k])) {
                    $config[$k] = [];
                }
                $config[$k] = array_merge($config[$k], $userconfig[$k]);
            }

            // default route keys
            foreach ($config['routes'] as $r => &$x) {
                // single or multi route entry
                if (isset($x['controller'])) {
                    // default method to GET
                    if (!isset($x['method'])) {
                        $x['method'] = 'GET';
                    }

                    // default action to index_action
                    if (!isset($x['action'])) {
                        $x['action'] = 'index_action';
                    }
                } else {
                    foreach ($x as &$xx) {
                        // default method to GET
                        if (!isset($xx['method'])) {
                            $xx['method'] = 'GET';
                        }

                        // default action to index_action
                        if (!isset($xx['action'])) {
                            $xx['action'] = 'index_action';
                        }
                    }
                }
            }

            return $config;
        },

        'router' => function ($c) {
            return new neo\core\router\Router($c['klein'], $c['controller_factory']);
        },

        'controller_factory' => function ($c) {
            return new neo\core\factory\ControllerFactory($c);
        },

        'model_factory' => function ($c) {
            return new neo\core\factory\ModelFactory($c);
        },

        'klein' => function () {
            return new Klein\Klein();
        },

        'endobox' => function ($c) {
            return new endobox\Factory($c['root_dir'] . '/templates');
        },

        'database_connection' => function ($c) {
            $config = $c['config']['mysql'];
            try {
                $pdo = new PDO(
                    sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s',
                        $config['host'],
                        $config['port'],
                        $config['dbname'],
                        $config['charset']),
                    $config['username'],
                    $config['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]);
            } catch (PDOException $e) {
                throw new RuntimeException($e->getMessage());
            }
            return $pdo;
        }

    ]
];

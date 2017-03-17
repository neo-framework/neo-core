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
            foreach ($config['routes'] as &$r) {
                if (!isset($r['method'])) {
                    $r['method'] = 'GET';
                }

                if (!isset($r['action'])) {
                    $r['action'] = 'index_action';
                }
            }

            return $config;
        },

        'router' => function ($c) {
            return new neo\router\Router($c['klein'], $c['controller_factory']);
        },

        'controller_factory' => function ($c) {
            return new neo\factory\ControllerFactory($c);
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

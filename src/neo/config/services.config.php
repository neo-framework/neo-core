<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

return [
    'services' => [

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
        },

        'config' => function ($c) {
            // read default config
            $config = [];
            foreach (new DirectoryIterator(__DIR__) as $f) {
                if ($f->isFile() && $f->getExtension() === 'php' && $f->getFilename() !== 'services.config.php') {
                    $c = require $f->getPathname();
                    $config = array_merge($config, $c);
                }
            }

            if (!defined('ROOT_DIR')) {
                return $config;
            }

            // read userland config
            $userconfig = [];
            foreach (new DirectoryIterator(ROOT_DIR . '/config') as $f) {
                if ($f->isFile() && $f->getExtension() === 'php' && $f->getFilename() !== 'services.config.php') {
                    $c = require $f->getPathname();
                    $userconfig = array_merge($userconfig, $c);
                }
            }

            // merge configs
            foreach ($userconfig as $k => $v) {
                if (!isset($config[$k])) {
                    $config[$k] = [];
                }
                $config[$k] = array_merge($config[$k], $userconfig[$k]);
            }

            return $config;
        },

        'router' => function ($c) {
            return new neo\router\Router($c['klein'], $c['controller_factory']);
        },

        'controller_factory' => function ($c) {
            return new neo\factory\ControllerFactory();
        },

        'view_factory' => function ($c) {
            // TODO
        },

        'model_factory' => function ($c) {
            // TODO
        },

        'klein' => function ($c) {
            return new Klein\Klein();
        }

    ]
];

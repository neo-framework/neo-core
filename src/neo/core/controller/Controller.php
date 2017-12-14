<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\core\controller;

use \Klein\Request;
use \Klein\Response;
use \endobox\BoxFactory;
use \endobox\Box;
use \neo\core\factory\ModelFactory;
use \neo\core\factory\ControllerPluginFactory;
use \neo\core\model\Model;

abstract class Controller
{

    protected $request;

    protected $response;

    private $view_factory;

    private $model_factory;

    private $plugins = [];
    private $plugin_methods = [];
    private $plugin_factory;

    public function __construct(
            Request $req,
            Response $resp,
            BoxFactory $endobox,
            ModelFactory $mf,
            ControllerPluginFactory $cpf)
    {
        $this->request = $req;
        $this->response = $resp;
        $this->view_factory = $endobox;
        $this->model_factory = $mf;
        $this->plugin_factory = $cpf;
    }

    public function __call(string $name, array $arguments)
    {
        if (!isset($this->plugin_methods[$name])) {
            throw new \BadMethodCallException(\sprintf(
                    'No such method "%s". Did you forget to load a plug-in?', $name));
        }
        if (!isset($this->plugins[$this->plugin_methods[$name]])) {
            throw new \RuntimeException(\sprintf(
                    'Failed to call method "%s" in plug-in "%s". Plug-in not loaded correctly.',
                    $name, $this->plugin_methods[$name]));
        }

        $plugin = $this->plugins[$this->plugin_methods[$name]];
        return $plugin->$name(...$arguments);
    }

    /**
     * Dynamically load a plugin.
     */
    protected function load(string $plugin)
    {
        // check if plugin instance already exists
        if (isset($this->plugins[$plugin])) {
            return;
        }

        // create and save new instance
        $this->plugins[$plugin] = ($this->plugin_factory)($plugin, [ $this, $this->request, $this->response ]);

        // get plugin entry points
        $this->plugin_methods = \array_merge(
                $this->plugin_methods,
                \array_fill_keys(\array_filter(\get_class_methods($this->plugins[$plugin]),
                function($v) { return \substr($v, 0, 2) !== '__'; }),
                $plugin));
    }

    /**
     * Usually, this is what I want to do:
     *
     * $test = $endobox('template');
     *
     * Now, $endobox is no longer a simple variable, but a property:
     *
     * $test = $this->view_factory('template');
     *
     * Except PHP will now think that we're trying to call a method named view_factory() which does not exist.
     * To fix this we'd have to write explicit parenthesis like this:
     *
     * $test = ($this->view_factory)('template');
     *
     * But that's pretty ugly and that's why this method exists.
     * Now I just write:
     *
     * $test = $this->view('template');
     */
     protected function view(string $template) : Box
     {
         return ($this->view_factory)($template);
     }

     /**
      * Get model instance by class name.
      */
     protected function model(string $modelname) : Model
     {
         return ($this->model_factory)($modelname);
     }

}

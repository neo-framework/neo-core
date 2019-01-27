<?php

/**
 * This file is part of Neo Framework.
 *
 * (c) 2016-2019 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\core\controller;

use \Klein\Request;
use \Klein\Response;
use \endobox\BoxFactory;
use \endobox\Box;
use \Psr\Log\LoggerInterface as Logger;

/**
 * Controller base class.
 *
 * All Controller classes within your Neo application should extend this one.
 */
abstract class Controller
{

    /**
     * @var Request The incoming request.
     */
    protected $request = null;

    /**
     * @var Response The outgoing response.
     */
    protected $response = null;

    /**
     * @var Logger This logger can be used to log all kinds of stuff within your {@link Controller}.
     */
    protected $logger = null;

    private $endobox = null;

    // TODO plug-ins

    /**
     * Default entry point of the Controller.
     *
     * @return mixed Response to be sent to the client.
     */
    abstract public function indexAction();

    // TODO allow implicit rendering: no need to return a response.
    // return type could be string or Response or ?Response. not sure which
    // in any case it's probably too explicit to return a Response object each time.

    /**
     * Initialize the Controller.
     * This gets called once after the Controller is fully constructed and all dependencies
     * (both user and framework dependencies) have been injected, yet before any action is called.
     *
     * This is where you usually set up some global settings that are relevant for the entire Controller class.
     *
     * Caveat: This is not equivalent to the constructor, because inside the constructor you won't have access
     * to things like the Request or Response object yet, whereas you do here.
     */
    public function initialize() {}

    /**
     *
     */
    protected function redirect()
    {
        // TODO allow relative and absolute redirects as well as controller + action redirects
    }

    /**
     * Inject a {@link Request} instance.
     *
     * @param Request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * Inject a {@link Response} instance.
     *
     * @param Response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Inject {@link BoxFactory} instance.
     *
     * @param BoxFactory
     */
    public function setBoxFactory(BoxFactory $endobox)
    {
        $this->endobox = $endobox;
        return $this;
    }

    /**
     * Inject a {@link Logger} instance.
     *
     * @param Logger
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * Call a plug-in method if one was loaded.
     *
     * @param string $name Method name.
     * @param array $arguments List of arguments to pass.
     * @return mixed Whatever the plug-in decides to return.
     * @throws \BadMethodCallException if no such plug-in was loaded.
     */
    public function __call(string $name, array $arguments)
    {
    }

    /**
     * Load a plug-in on the fly.
     *
     * @param string $plugin Name of the plug-in.
     */
    protected function loadPlugin(string $plugin)
    {
    }

    /**
     * Shortcut to access endobox in a more convenient manner.
     *
     * @param string $template Name of the template you want to create.
     * @return Box The Box holding your template.
     */
    protected function view(string $template) : Box
    {
        return ($this->endobox)($template);
    }

}

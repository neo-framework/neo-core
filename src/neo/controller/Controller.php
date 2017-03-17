<?php

/**
 * Neo Framework
 *
 * @link https://neo-framework.github.io
 * @copyright Copyright (c) 2016-2017 YouniS Bensalah <younis.bensalah@gmail.com>
 * @license MIT
 */

namespace neo\controller;

use \Klein\Request;
use \Klein\Response;
use \endobox\Factory as Endobox;
use \endobox\Box;

abstract class Controller
{

    protected $request;

    protected $response;

    protected $view;

    public function __construct(Request $request, Response $response, Endobox $endobox)
    {
        $this->request = $request;
        $this->response = $response;
        $this->view = $endobox;
    }

    /**
     * Usually, this is what I want to do:
     *
     * $test = $endobox('mytemplate');
     *
     * Now, $endobox is no longer a simple variable, but a property:
     *
     * $test = $this->view('mytemplate');
     *
     * Except PHP will now think that we're trying to call a method named view() which does not exist.
     * To fix this we'd have to write explicit parenthesis like this:
     *
     * $test = ($this->view)('mytemplate');
     *
     * But that's pretty ugly and that's why this method exists.
     */
     public function view(string $template) : Box
     {
         return ($this->view)($template);
     }

}

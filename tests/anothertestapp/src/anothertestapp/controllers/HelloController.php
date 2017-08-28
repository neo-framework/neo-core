<?php

namespace anothertestapp\controllers;

use \neo\core\controller\Controller;

class HelloController extends Controller
{

    public function index_action()
    {
        return "hello";
    }

    public function foo_action()
    {
        return "foo";
    }

}

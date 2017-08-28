<?php

namespace anothertestapp\controllers;

use \neo\core\controller\Controller;

class HiController extends Controller
{

    public function index_action()
    {
        return "hi";
    }

    public function bar_action()
    {
        return "bar";
    }

}

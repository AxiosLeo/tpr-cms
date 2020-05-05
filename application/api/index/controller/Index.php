<?php

declare(strict_types = 1);

namespace api\index\controller;

use tpr\Config;
use tpr\Controller;

class Index extends Controller
{
    public function index()
    {
        $this->response([
            "code"   => "200",
            "msg"    => "hello, world!",
            "config" => Config::get()
        ]);
    }
}

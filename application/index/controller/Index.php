<?php

namespace app\index\controller;

use tpr\Controller;

class Index extends Controller
{
    public function index()
    {
        return "hello,world";
    }

    public function test()
    {
        $this->setResponseType("json");
        $this->response(["test"]);
    }

    public function param($path_params)
    {
        $this->setResponseType("json");
        $this->response($path_params);
    }

    public function page()
    {
        $this->assign("title", "hello, world!");
        $this->assign("listItem", [
            [
                "value" => "/index/1/title",
                "name"  => "LinkName"
            ]
        ]);
        return $this->fetch("index/index:index");
    }
}

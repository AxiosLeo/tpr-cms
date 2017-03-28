<?php
namespace app\index\controller;

use app\common\controller\ApiBase;

class Index extends ApiBase
{
    public function index()
    {
        $this->response(['name'=>"hello world"]);
    }
    public function hello()
    {
        $this->response(['hello'=>"world"]);
    }
}

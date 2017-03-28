<?php
namespace app\index\controller;

use app\common\controller\ApiBase;

class Index extends ApiBase
{
    public function index()
    {
//        dump($this->request);
//        dump($this->request->path());
        $this->response(['name'=>"test"]);
    }
    public function hello()
    {
        $this->response(['hello'=>"world"]);
    }
}

<?php
namespace app\index\controller;

use app\common\controller\ApiBase;

class Index extends ApiBase
{
    public function index()
    {
        dump($this->request);
        $this->response(['name'=>"test"]);
    }
}

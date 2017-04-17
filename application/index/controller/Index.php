<?php
namespace app\index\controller;

use app\common\controller\ApiBase;
use app\common\service\MongoService;

class Index extends ApiBase
{
    public function index()
    {
        $this->response(['name'=>"hello world"]);
    }
    public function hello()
    {
        $this->response(['hello'=>"world",'test'=>"a"]);
    }

    public function mongo(){
        $Mongo = MongoService::name('test');
        dump($Mongo);

        $data = $Mongo->select();
        dump($data);

        $Mongo->insertGetId(['timestamp'=>"123"]);
        dump($Mongo->select());

        $Mongo->where('timestamp',"123")->delete();
        dump($Mongo->select());
    }
}
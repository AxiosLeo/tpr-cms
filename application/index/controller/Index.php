<?php
namespace app\index\controller;

use app\common\controller\ApiBase;
use app\common\service\ApiDocService;
use app\common\service\MongoService;

class Index extends ApiBase
{
    /**
     * 默认接口
     * @desc 默认访问的接口
     * @return string param_name param_info
     */
    public function index()
    {
        $this->response(['name'=>"hello world"]);
    }

    public function hello()
    {
        $this->response(['hello'=>"world",'test'=>"a"]);
    }

    public function doc(){
        $this->response(ApiDocService::api());
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
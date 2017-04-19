<?php
namespace app\index\controller;

use app\common\controller\ApiBase;
use app\common\service\ApiDocService;
use app\common\service\MongoService;

/**
 * 接口类名
 * @desc 接口类描述
 * @package 所属命名空间
 */
class Index extends ApiBase
{
    /**
     * 接口名称
     * @desc 接口描述
     * @parameter 参数类型 参数名称
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
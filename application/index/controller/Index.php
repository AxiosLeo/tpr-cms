<?php
namespace app\index\controller;

use app\common\controller\ApiBase;
use think\Config;
use think\Db;
class Index extends ApiBase
{
    public function index()
    {
        $this->response(['name'=>"hello world"]);
    }
    public function hello()
    {
        sleep(3);
        dump("hello");
        $this->response(['hello'=>"world",'test'=>"a"]);
    }

    public function mongo(){
        $config = Config::get('mongo');
        $test = Db::connect($config)->name('test')->select();
        dump($test);
    }
}
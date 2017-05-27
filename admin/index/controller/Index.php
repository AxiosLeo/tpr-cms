<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 10:10
 */
namespace admin\index\controller;

use admin\common\controller\HomeLogin;
use axios\tpr\service\MongoService;

class Index extends HomeLogin {
    public function index(){
//        $test = MongoService::name('test')->select();
//        dump($test);
//        $result = MongoService::checkConnect();
//        dump($result);
//        \MongoClient::class;
//        dump($result);
//        $this->assign('menu',$this->menu());
        return $this->fetch('index');
    }

    public function main(){
        return $this->fetch('main');
    }
}
<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 17:09
 */
namespace admin\system\controller;

use admin\common\controller\HomeLogin;
use think\Doc;

class Api extends HomeLogin{
    public function index(){
        if($this->request->isPost()){
            $api_dir = [
                ROOT_PATH . 'api/index/controller',
            ];
            Doc::config($api_dir, ROOT_PATH . 'api');
            $doc = Doc::doc();
//            $this->response(['domain'=>env('api.host',''),'doc'=>$doc]);
            $this->response([]);
        }
        $api_dir = [
            ROOT_PATH . 'api/index/controller',
        ];
        Doc::config($api_dir, ROOT_PATH . 'api');
        $doc = Doc::doc();
        $this->assign('list',$doc);
        $this->assign('domain',env('api.host',''));
        return $this->fetch('index');
    }

}
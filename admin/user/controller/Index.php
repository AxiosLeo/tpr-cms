<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/19 14:36
 */
namespace admin\user\controller;

use admin\common\controller\HomeLogin;
use think\Db;

class Index extends HomeLogin{
    public function profile(){
        $role = Db::name('role')->where('id',$this->user['role_id'])->find();
        $this->assign('role_name',$role['role_name']);
        return $this->fetch('profile');
    }

    public function password(){
        if($this->request->isPost()){
            $this->error(json_encode($this->param));
        }
        return $this->fetch('password');
    }
}
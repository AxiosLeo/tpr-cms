<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 10:59
 */

namespace api\example\controller;

use axios\tpr\core\Api;
use api\example\service\LoginService;
use think\Db;

class Forgot extends Api{
    /**
     * @title 忘记密码
     * @parameter string username 用户名
     * @parameter string password 密码
     * @a string test
     * @a int test2
     * @single int a
     * @single a
     * @singleString a;
     * @singleString b;
     * @singleString c;
     * @singleString d
     */
    public function index(){
        $username = $this->param['username'];
        $password = $this->param['password'];

        if(Db::name('users')->where('login_name',$username)->count()){
            $this->wrong(404100,"user@nt@exits");
        }

        $user_uniq = uniqid($username);
        $password  = make_password($password,$user_uniq);

        $data = [
            'user_uniq'=>$user_uniq,
            'login_pass'=>$password,
        ];

        $user_id = Db::name('users')->where('login_name')->update($data);
        if($user_id){
            $user = Db::name('users')->find($user_id);
            $result = LoginService::login($user);
            if(is_int($result)){
                $this->wrong($result);
            }
            $this->response($result);
        }

        $this->wrong(500);
    }
}
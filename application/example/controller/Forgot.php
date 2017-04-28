<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/26 10:50
 */
namespace app\example\controller;
use axios\tpr\controller\ApiLogout;
//use axios\tpr\service\UserService;
use think\Db;
use app\example\service\LoginService;

/**
 * Class Forgot
 * @package app\example\controller
 */
class Forgot extends ApiLogout{
    /**
     * 忘记密码
     * @desc 用于用户找回密码
     * @method post
     * @parameter string username 用户名
     * @parameter string password 密码
     * @response string login_name 用户名
     * @response string token  令牌
     */
    public function index(){
        $username  = $this->param['username'];
        $password  = $this->param['password'];

        if(!Db::name('users')->where('login_name',$username)->count()){
            $this->wrong(404100,"user@not@exits");
        }

//        $verify   = $this->param['verify'];
//        $check = UserService::checkVerifyCode($username,$verify);
//        if($check){
//            $this->wrong($check);
//        }

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
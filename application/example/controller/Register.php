<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/26 10:47
 */
namespace app\example\controller;

use axios\tpr\controller\ApiBase;
use think\Db;
use app\example\service\LoginService;
/**
 * Class Register
 * @package app\example\controller
 */
class Register extends ApiBase {
    /**
     * 注册接口
     * @method post
     * @parameter string username 用户名
     * @parameter string password 密码
     * @parameter string nickname 非必须
     */
    public function index(){
        $username  = $this->param['username'];
        $password  = $this->param['password'];

        if(Db::name('users')->where('login_name',$username)->count()){
            $this->wrong(402100,"User name already exists");
        }

        /***针对短信通知验证码的验证***/
//        $verify   = $this->param['verify'];
//        $check = UserService::checkVerifyCode($username,$verify);  // 验证码检查
//        if($check){
//            $this->wrong($check);
//        }

        $user_uniq = uniqid($username);
        $password  = make_password($password,$user_uniq);

        $data = [
            'user_uniq'=>$user_uniq,
            'login_name'=>$username,
            'login_pass'=>$password,
            'created_at'=>time()
        ];

        if(isset($this->param['nickname']) && !empty($this->param['nickname'])){
            $data['nickname']  = $this->param['nickname'];
        }

        $user_id = Db::name('users')->insertGetId($data);
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
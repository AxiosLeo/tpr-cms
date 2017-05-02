<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/26 10:44
 */
namespace app\example\controller;

use axios\tpr\controller\ApiBase;
use app\example\model\UserModel;
use app\example\service\LoginService;
/**
 * Class Login
 * @package app\example\controller
 */
class Login extends ApiBase {
    /**
     * 登陆接口
     * @desc 验证用户名密码
     * @method POST
     * @parameter string username 用户名
     * @parameter string password 密码
     * @response string token 令牌
     */
    public function index(){
        $username = $this->param['username'];
        $password = $this->param['password'];


        $user = UserModel::self()->findUser(0,$username);
        if(empty($user)){
            $this->wrong(404100);
        }

        if($user['login_pass']!=make_password($password,$user['user_uniq'])){
            $this->wrong(400100);
        }
        $result = LoginService::login($user);
        if(is_int($result)){
            $this->wrong($result);
        }

        $this->response($result);
    }
}
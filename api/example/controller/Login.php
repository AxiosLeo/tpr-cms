<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:07
 */
namespace api\example\controller;

use axios\tpr\core\Api;
use api\example\model\UserModel;
use api\example\service\LoginService;

class Login extends Api{
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
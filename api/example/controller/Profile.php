<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:09
 */
namespace api\example\controller;

use api\common\controller\ApiLogin;
use api\example\model\UserModel;
use api\example\service\LoginService;

/**
 * Class Profile
 * @package app\example\controller
 */
class Profile extends ApiLogin
{
    /**
     * 获取用户信息接口
     * @method post
     * @parameter string token 必须
     */
    public function index()
    {
        $user = $this->user;
        if (isset($user['token'])) {
            unset($user['token']);
        }

        $this->response($user);
    }

    /**
     * 更新用户信息
     * @method post
     * @parameter string nickname
     */
    public function update()
    {
        $data = [];
        $user = [];
        if (isset($this->param['nickname']) && !empty($this->param['nickname'])) {
            $data['nickname'] = $this->param['nickname'];
        }

        if (!empty($data) && UserModel::self()->updateUser($data, $this->user['id'])) {
            $user = LoginService::doLogin($this->user['id'], $this->user['token']);
            $this->response($user);
        }
        if (empty($user)) {
            $user = $this->user;
            unset($user['id']);
            unset($user['token']);
        }
        return $this->response($this->user);
    }
}
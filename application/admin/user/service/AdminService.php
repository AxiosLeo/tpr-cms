<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/6/7 9:23
 */

namespace tpr\admin\user\service;

use think\Session;
use think\Db;

class AdminService
{
    public static function getSessionInfo($id)
    {
        $user = Db::name('admin')->where('id', $id)->find();
        unset($user['security_id']);
        unset($user['password']);
        Session::set('user', $user);
        return $user;
    }
}
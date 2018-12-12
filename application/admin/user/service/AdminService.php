<?php
/**
 * @author  : Axios
 * @email   : axioscros@aliyun.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2017/6/7 9:23
 */

namespace tpr\admin\user\service;

use library\connector\Mysql;

class AdminService
{
    /**
     * @param $id
     *
     * @return array|false|\PDOStatement|string
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    public static function getSessionInfo($id)
    {
        $user = Mysql::name('admin')->where('id', $id)->find();
        unset($user['security_id']);
        unset($user['password']);
        user_save($user);
        return $user;
    }
}
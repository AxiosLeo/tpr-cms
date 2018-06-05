<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/12/25 16:04
 */

namespace library\logic;

use library\connector\Mysql;
use tpr\framework\Session;

class UserLogic
{
    public static $user = null;

    /**
     * @param $open_id
     * @param $wechat
     * @return array|false|null|\PDOStatement|string
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    public static function getUserInfoByOpenId($open_id, $wechat){
        self::$user = Mysql::name('users')->alias('u')
            ->join('__USERS_WECHAT__ uw','uw.user_uniq=u.user_uniq','left')
            ->where('uw.openid', $open_id)
            ->where('uw.wechat',$wechat)
            ->field('u.user_uniq , u.login_name ,  u.nickname , uw.openid,uw.wechat')
            ->find();
        Session::set('user_info', self::$user , PROJECT_NAME);

        return self::$user;
    }

    /**
     * @param $login_name
     * @param $wechat
     * @return array|false|null|\PDOStatement|string
     * @throws \ErrorException
     * @throws \tpr\db\exception\BindParamException
     * @throws \tpr\db\exception\Exception
     * @throws \tpr\db\exception\PDOException
     */
    public static function getUserInfoByLoginName($login_name, $wechat){
        self::$user = Mysql::name('users')->alias('u')
            ->join('__USERS_WECHAT__ uw','uw.user_uniq=u.user_uniq','left')
            ->where('u.login_name',$login_name)
            ->where('uw.wechat',$wechat)
            ->field('u.user_uniq,u.login_name,u.nickname,,uw.openid,uw.wechat')
            ->find();
        Session::set('user_info',self::$user , PROJECT_NAME);
        return self::$user;
    }

    public static function wechat($user_uniq , $openid , $wechat){
        $users_wechat = [
            'openid'=>$openid,
            'wechat'=>$wechat,
            'user_uniq'=>$user_uniq,
            'timestamp'=>time()
        ];
        // 建立该用户与当前微信公众号的关联记录
        return Mysql::name('users_wechat')->insert($users_wechat,true);
    }
}
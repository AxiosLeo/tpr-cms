<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/12/25 16:04
 */

namespace library\logic;

use think\Db;
use think\Session;

class UserLogic
{
    public static $user = null;

    public static function getUserInfoByOpenId($open_id, $wechat){
        self::$user = Db::name('users')->alias('u')
            ->join('__USERS_WECHAT__ uw','uw.user_uniq=u.user_uniq','left')
            ->where('uw.openid', $open_id)
            ->where('uw.wechat',$wechat)
            ->field('u.user_uniq , u.login_name , u.realname , u.nickname , u.sex , u.mobile , u.head_image,uw.openid,uw.wechat')
            ->find();
        Session::set('user_info', self::$user , PROJECT_NAME);

        return self::$user;
    }

    public static function getUserInfoByLoginName($login_name, $wechat){
        self::$user = Db::name('users')->alias('u')
            ->join('__USERS_WECHAT__ uw','uw.user_uniq=u.user_uniq','left')
            ->where('u.login_name',$login_name)
            ->where('uw.wechat',$wechat)
            ->field('u.user_uniq,u.login_name,u.realname,u.nickname,u.sex,u.mobile,u.head_image,uw.openid,uw.wechat')
            ->find();
        Session::set('user_info',self::$user , PROJECT_NAME);
        return self::$user;
    }

    public static function addUserRelation($user_uniq){
        $user_relation = [
            'user_uniq'=>$user_uniq,
            'bind_uniq'=>$user_uniq,
            'bind_time'=>time()
        ];
        $exist = Db::name('user_relation')->where('user_uniq',$user_uniq)
            ->where('bind_uniq',$user_uniq)
            ->count();
        if(!$exist){
            Db::name('user_relation')->insert($user_relation);
        }
    }

    public static function wechat($user_uniq , $openid , $wechat){
        $users_wechat = [
            'openid'=>$openid,
            'wechat'=>$wechat,
            'user_uniq'=>$user_uniq,
            'timestamp'=>time()
        ];
        // 建立该用户与当前微信公众号的关联记录
        return Db::name('users_wechat')->insert($users_wechat,true);
    }
}
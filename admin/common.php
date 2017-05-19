<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:30
 */

function is_user_login(){
    $user = \think\Session::has('user');
    return  empty($user) ? false:true;
}

function user_info(){
    $user = \think\Session::get('user');
    return $user;
}

function user_current_id(){
    $user = user_info();
    return $user['id'];
}

function getLastUrl(){
    return \think\Session::get('last_url');
}

function make_password($password,$auth=''){
    return md5($auth.$password);
}
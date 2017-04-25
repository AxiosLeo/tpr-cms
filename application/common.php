<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
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

function make_password($password,$auth){
    return md5($auth.$password);
}

function trans($message){
    return \axios\tpr\service\LangService::trans($message);
}
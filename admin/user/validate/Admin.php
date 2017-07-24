<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/24 13:43
 */

namespace admin\user\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'role_id' => ['require'],
        'mobile' => ['number', 'length:11', 'regex:/^1[34578]{1}\d{9}$/'],
        'email' => ['regex:/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/'],

        'username' => ['require', 'length:5,32', 'regex:/^([a-z]|[0-9])*$/i'],
        'password' => ['require', 'length:6,24', 'regex:/^([a-z]|[0-9])*$/i'],

        'realname' => ['require', 'length:2,32'],
        'nickname' => ['require', 'length:2,32']
    ];

    protected $message = [
        'role_id.require' => "请选择角色",
        'username.require' => "请输入用户名",
        'username.length' => "用户名只能在5~32位之间",
        'username.regex' => '用户名只能由数字和字母组成',
        'mobile.number' => "手机号格式不正确",
        'mobile.length' => '手机号格式不正确',
        'mobile.regex' => '手机号格式不正确',
        'email.regex' => '邮箱格式不正确',
        'password.require' => "请输入用户密码",
        'password.length' => '用户密码只能在6~24位之间',
        'password.regex' => '密码只能由数字和字母组成',

        'realname.require' => '请输入真实姓名',
        'realname.length' => '姓名长度需在2~32位之间',
        'nickname.require' => '请输入昵称',
        'nickname.length' => '昵称长度需在2~32位之间',
    ];

    protected $scene = [
        'add' => ['role_id', 'username', 'password', 'mobile', 'email'],
        'update' => ['role_id', 'username', 'mobile', 'email'],
        'profile' => ['realname', 'mobile'],
        'password' => ['password']
    ];
}
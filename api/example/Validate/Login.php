<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:18
 */
namespace api\example\validate;

use axios\tpr\core\Validate;

class Login extends Validate{
    protected $rule =   [
        'username'  => 'require|max:25',
        'password'  => 'require|max:25',
    ];

    protected $message  =   [
        'username.require' => 'name@require',  //支持分段翻译,每段由@符号隔开
        'username.max'     => 'name@must be less than@25@char',

        'password.require' => 'name@require',
        'password.max'     => 'name@must be less than@25@char',
    ];

    protected $scene = [
        'needName'  =>  ['index'],
    ];
}
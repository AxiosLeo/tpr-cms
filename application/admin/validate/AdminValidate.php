<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/26 10:14
 */
namespace app\users\validate;

use axios\tpr\validate\ValidateBase;
class AdminValidate extends ValidateBase{
    protected $rule = [
        'username'   =>  ['require','length:2,32','regex:/^([a-z]|[0-9])*$/i'],
        'password'   =>  ['require','length:6,16','regex:/^([a-z]|[0-9])*$/i'],
        'mobile'     =>  ['length:11','regex:/^1[34578]{1}\d{9}$/'],

        'app_name'   =>  ['require','length:2,128'],
        'base_version' =>['require','number'],

        'app_id'     =>  ['require','min:1']
    ];

    protected $message = [
        'username.require' => "username@not@exits",
        'username.length'  => 'username@length@error',
        'username.regex'   => "username@format@error",
        'password.require' => 'password@not@exits',
        'password.length'  => 'password@length@error',
        'password.regex'   => 'password@format@error',

        'mobile.length'  => 'mobile@length@error',
        'mobile.regex'  => 'mobile@format@error',

        'app_name.require'=>'app_name@not@exits',
        'app_name.length'=>'app_name@length@must be@2~128',
        'base_version.require'=>'base_version@must not be@empty',
        'base_version.number'=>'base_version@must be@number',

        'app_id.require'=>"app_id@not@exits",
        'app_id.min'=>"select at least one application"

    ];

    protected $scene = [
        'admin.add'=>['username', 'password'],
        'admin.edit'=>['username'],
        'software.add'=>['app_name', 'base_version'],
        'version.add'=>['app_id']
    ];
}
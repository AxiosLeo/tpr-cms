<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/9/20 上午9:51
 */

namespace tpr\admin\app\validate;

use tpr\framework\Validate;

class Application extends Validate
{
    protected $rule = [
        'app_name'   =>  ['require','length:2,128'],
        'base_version' =>['require','number'],
        'app_id'     =>  ['require','min:1']
    ];

    protected $message = [
        'app_name.require'=>'app_name@not@exits',
        'app_name.length'=>'app_name@length@must be@2~128',
        'base_version.require'=>'base_version@must not be@empty',
        'base_version.number'=>'base_version@must be@number',

        'app_id.require'=>"app_id@not@exits",
        'app_id.min'=>"select at least one application"
    ];

    protected $scene = [
        'software.add'=>['app_name', 'base_version'],
        'version.add'=>['app_id']
    ];
}
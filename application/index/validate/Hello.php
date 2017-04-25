<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/27 11:12
 */
namespace app\common\validate;
use axios\tpr\validate\ValidateBase;
class Hello extends ValidateBase {
    protected $rule =   [
        'name'  => 'require|max:25',
    ];

    protected $message  =   [
        'name.require' => 'name@require',  //支持分段翻译,每段由@符号隔开
        'name.max'     => 'name@must be less than@25@char',
    ];

    protected $scene = [
        'scene-name'  =>  ['name'],
    ];

}
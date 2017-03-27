<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/27 11:12
 */
namespace app\common\validate;

class Hello extends Base {
    protected $rule =   [
        'name'  => 'require|max:3',
    ];

    protected $message  =   [
        'name.require' => 'name@require',
        'name.max'     => 'name@must be less than@25@char',
    ];

    protected $scene = [
        'scene-name'  =>  ['name'],
    ];

}
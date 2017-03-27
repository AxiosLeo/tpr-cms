<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/27 17:44
 */
namespace app\index\validate;

use app\common\validate\Base;

class Index extends Base {
    protected $rule =   [
        'id'  => 'require|max:11',
    ];

    protected $message  =   [
        'name.require' => 'id@require',
        'name.max'     => 'id@must be less than@11@char',
    ];

    protected $scene = [
        'scene-name'  =>  ['index'],
    ];

}
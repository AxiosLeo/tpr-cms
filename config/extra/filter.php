<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/27 10:20
 */

return [
    //route name
    'hello'=>['validate'=>'Hello','scene'=>'scene-name','mobile'=>false,'cache'=>300],  // cache : expire=> (int)second

    //module/controller/action
    'index/index/test'=>['validate'=>'Hello','scene'=>'scene-name','mobile'=>false]
];
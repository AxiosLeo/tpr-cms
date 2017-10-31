<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/7 下午5:38
 */

return [
    'dispatch_success_tmpl'  => ROOT_PATH . 'views' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => ROOT_PATH . 'views' . DS . 'dispatch_jump.tpl',

    'middleware'=>[
        /***
         * 'module/controller/action'=>['MiddlewareClassName','MiddlewareFunctionName']
         ***/
        'before'=>[
//        'index/index/index'=>['tpr\index\middleware\index','index'],
//        'index/index/test'=>['index','test'],
        ],
        'after'=>[
//        'index/index/index'=>['tpr\index\middleware\index','index'],
//        'index/index/test'=>['index','test'],
        ]
    ]
];
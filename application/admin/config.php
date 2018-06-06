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

    'template' => [
        // 模板引擎类型 支持 php think 支持扩展
        'type' => 'Think',
        // 模板路径
        'view_path' => ROOT_PATH . 'views/' . PROJECT_NAME . '/',
        // 模板后缀
        'view_suffix' => 'html',
        // 模板文件名分隔符
        'view_depr' => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin' => '{',
        // 模板引擎普通标签结束标记
        'tpl_end' => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end' => '}',
    ],

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
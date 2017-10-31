<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/31 16:56
 */


//在这里配置的中间件，在所有应用中都有效，若要只在某个应用中有效的话，就修改APP_PATH/config.php的配置
return [
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
];
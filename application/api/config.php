<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/6/29 15:23
 */
return [
    // 异常处理handle类 留空使用 \tpr\framework\exception\Handle
    'exception_handle' => '\\tpr\\framework\\exception\\HttpRestException',

    'default_ajax_return'    => 'json',

    'request_cache'	=>	true,
    'request_cache_expire'	=>	30,
    'request_cache_except' =>	[
        '/index/index/cache',
    ],
];
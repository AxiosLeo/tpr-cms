<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/28 19:48
 */
namespace app\common\middleware;

use think\Controller;

class Test extends Controller {
    public function log(){
        trace('日志信息','info');
    }
}
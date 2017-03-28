<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/3/28 18:04
 */
namespace app\common\middleware;
use think\Controller;
use think\Db;
use think\Request;
class Hello extends Controller {
    function __construct( Request $request=null)
    {
        parent::__construct($request);
    }

    public function before(){
        echo "hello,this is before middleware.";
    }
    public function after(){
        sleep(5);
        Db::name("test")->insert(['datetime'=>date("Y-m-d H:i:s")]);
        sleep(5);
        Db::name("test")->insert(['datetime'=>date("Y-m-d H:i:s")]);
        echo "hello,this is after middleware.";
    }
}
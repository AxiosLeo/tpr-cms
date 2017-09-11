<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/9/5 上午10:46
 */

namespace tpr\admin\index\controller;


use think\Controller;

class Message extends Controller
{
    /**
     * @except
     */
    public function none(){
        $this->ajaxReturn([
            'code'=>401,
            'msg'=>'无授权'
        ]);
    }
}
<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/25 上午10:35
 */

namespace tpr\server\index\controller;

use library\extend\workman\lib\Connect;
use library\extend\workman\lib\Single;
use tpr\framework\Controller;

class Index extends Controller
{
    public function index(){
//        Single::send($this->request->param('connection_id'),'this is single send');
//        $this->randSend();
        $this->response($this->request->param());
    }

    public function randSend(){
        $client_list = Connect::allConnection();
        $list = [];
        foreach ($client_list as $cl){
            array_push($list,$cl->connection_id);
        }
        dump($list);

        $total = count($list);
        $select = mt_rand(0,$total-1);

        Single::send($list[$select],'this is rand single send:'.$list[$select]);
    }
}
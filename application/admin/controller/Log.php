<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/15 10:43
 */
namespace app\admin\controller;

use app\common\controller\HomeLogin;
use axios\tpr\service\MongoService;
use think\Config;
use think\Request;

class Log extends HomeLogin{
    private $log_database;
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->log_database = Config::get('log.database');
        $this->assign('select_menu','icon-cogs');
    }

    public function getLog(){
        $page = $this->param['page'];
        $rows = $this->param['rows'];

        MongoService::name($this->log_database)->where('datetime','')->delete();

        $Mongo = MongoService::name($this->log_database);
        if(isset($this->param['log_type']) && !empty($this->param['select_api'])){
            $Mongo->where('log_type',$this->param['log_type']);
        }
        if(isset($this->param['start_date']) && !empty($this->param['select_api'])){
            $tamp = strtotime($this->param['start_date']);
            $Mongo->where('timestamp','>',$tamp);
        }

        if(isset($this->param['end_date']) && !empty($this->param['select_api'])){
            $tamp = strtotime($this->param['end_date']);
            $Mongo->where('timestamp','<',$tamp);
        }

        if(isset($this->param['select_api']) && !empty($this->param['select_api'])){
            $temp = explode("/",$this->param['select_api']);
            $Mongo->where('module',$temp[0])->where('controller',$temp[1])->where('action',$temp[2]);
        }

        $data =  ['total'=>$Mongo->count(),'rows'=>$Mongo->page($page)->limit($rows)->select()];

        return $data;
    }

    public function detail(){
        $id = $this->param['id'];
        $log = MongoService::name($this->log_database)->where('_id',$id)->find();
        return $this->fetch('detail',['log'=>$log]);
    }
    public function delete(){
        $id = $this->param['id'];
        MongoService::name($this->log_database)->where('_id',$id)->delete();
        $this->success("操作成功");
    }
}
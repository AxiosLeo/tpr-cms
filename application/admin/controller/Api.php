<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/25 17:16
 */
namespace app\admin\controller;

use app\common\controller\HomeLogin;
use axios\tpr\service\ApiDocService;
use axios\tpr\service\MongoService;
use think\Config;
use think\Env;
use think\Log;
use think\Request;
use traits\controller\Jump;

class Api extends HomeLogin{
    use Jump;
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->assign('select_menu','icon-cogs');
    }

    public function index(){
        $api = ApiDocService::api();
        $this->assign('domain',domain());
        return $this->fetch('index',['list'=>$api]);
    }

    public function detail(){
        $class = $this->param['class'];
        $this->assign('class_name',$class);
        $method = $this->param['method'];
        $result = ApiDocService::makeMethodDoc($class,$method);
        $this->assign('domain',domain());
        return $this->fetch('detail',['data'=>$result]);
    }

    public function log(){
        return $this->fetch('log',['list'=>[]]);
    }

    public function getLogs(){
        $page = isset($this->param['page'])?$this->param['page']:1;
        $logs = MongoService::name('tpr_log')->page($page)->limit(15)->order('datetime')->select();
    }

    public function getVisitData(){
        $year = $this->param['year'];
        $min = strtotime($year."-01");
        $max = strtotime($year."-12");
        $data = [];$n=0;

        $database = Env::get('log.database');
        for($i=1;$i<13;$i++){
            $date = getMonthBeginEndDay($year,$i);
            $count = MongoService::name($database)
                ->where('timestamp','between',[$date['begin'],$date['end']])
                ->count();
            $data[$n++] = [$date['begin']*1000,$count];
        }

        $option = [
            'xaxis'=>[
                "min"=>$min*1000,
                "max"=>$max*1000,
                "mode"=>"time",
                "tickSize"=>[1,"month"],
                "monthNames"=>["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                "tickLength"=>0
            ],
            'series'=>[
                "lines"=>[
                    "fill"=>true,
                    "lineWidth"=>1.5
                ],
                "points"=>[
                    "show"=>true,
                    "radius"=>2.5,
                    "lineWidth"=>1.1
                ],
                "grow"=>[
                    "active"=>true,
                    "growings"=>[["stepMode"=>"maximum"]]
                ]
            ],
            'grid'=>[
                "hoverable"=>true,
                "clickable"=>true,
            ],
            'tooltip'=>true,
            'tooltipOpts'=>[
                "content"=>"%s %y"
            ]
        ];

        return [
            "option"=>$option,
            "data"=>$data
        ];
    }
}
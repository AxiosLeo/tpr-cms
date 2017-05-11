<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/25 15:43
 */
namespace app\admin\controller;

use app\common\controller\HomeLogin;
use axios\tpr\service\MongoService;
use think\Config;
use think\Env;

class Index extends HomeLogin {
    public function index(){
        $database   = Env::get('log.database');
        $log_status =  Env::get('log.status');
        if(class_exists('MongoDB\Driver\Manager') && !empty($database) && !empty($log_status)){
            $total       = MongoService::name($database)->count();
            $error       = MongoService::name(Config::get('log.database'))->where('log_type','error')->count();
            $today       = date("Y-m-d");
            $todayDate   = getDayBeginEndTime($today);
            $todayVisit  = MongoService::name($database)->where('timestamp','between',[$todayDate['begin'],$todayDate['end']])->count();
            $lastDate    = getDayBeginEndTime(date("Y-m-d",strtotime("$today -1 day")));
            $lastVisit   = MongoService::name($database)->where('timestamp','between',[$lastDate['begin'],$lastDate['end']])->count();
            $today       = date("Y-m-d H:00:00");
            $str         = "";
            $sum         = 0;
            for($i=0;$i<12;$i++){
                $cut  = 12 - $i;
                $date = date("Y-m-d",strtotime("$today -$cut hour" ));
                $hour = date("H",strtotime("$today -$cut hour" ));
                $time = getHourBeginEndTime($date,$hour);
                if($i!=0){
                    $str .=",";
                }
                $visit = MongoService::name($database)->where('timestamp','between',[$time['begin'],$time['end']])->count();
                $str  .= $visit;
                $sum  += $visit;
            }
            $this->assign('lastDayVisit',$str);
            $this->assign('lastDayVisitAll',$sum);
            return $this->fetch('index',['total'=>$total,'error'=>$error,'todayVisit'=>$todayVisit,'lastVisit'=>$lastVisit]);
        }else{
            return $this->fetch('index2');
        }
    }

}
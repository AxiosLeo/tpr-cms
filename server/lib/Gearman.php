<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/26 上午9:15
 */

namespace server\lib;

use \GearmanWorker;
use \GearmanJob;
use server\traits\Jump;
use think\Debug;

require ROOT_PATH . 'server/traits/Jump.php';

class Gearman
{
    use Jump;

    protected static $handle;

    protected static $gearman_config = [
        "servers" => "127.0.0.1:4730",
        "timeout" => 10000
    ];

    public static function run($config = [], $job_name = "job")
    {
        self::$gearman_config = array_merge(self::$gearman_config, $config);

        $worker = new GearmanWorker();

        $worker->addServers(self::$gearman_config['servers']);

        $worker->addFunction($job_name, function ($job) {
            Gearman::job($job);
        });

        $worker->setTimeout(self::$gearman_config['timeout']);

        while (@$worker->work() || $worker->returnCode() == GEARMAN_TIMEOUT) {
            if ($worker->returnCode() == GEARMAN_TIMEOUT) {
                echo "Timeout. Waiting for next job...\n";
                die();
            }
            if ($worker->returnCode() != GEARMAN_SUCCESS) {
                echo "return_code: " . $worker->returnCode() . "\n";
                die();
            }
        }
    }

    public static function job(GearmanJob $job)
    {
        self::$handle = (string)$job->handle();

        $data = $job->workload();

        $data = self::data($data);

        self::result($data);
    }

    protected static function result($result = [], array $header = [])
    {
        if (isset($result['time'])) {
            $result['time'] = time();
        }

        $str = " [handle] " . self::$handle . "\n";
        self::text($header, $str, 'header');


        self::text($result, $str, 'data');

        $log_path = RUNTIME_PATH . 'gearman/' . date("Ym") . "/" . date("d") . "_gearman.log";
        $str .= "-----------------------------------------------------------------------------------\n\n";

        Debug::save($log_path, $str);
    }

    protected static function text($data, &$str = "", $type = "data")
    {
        foreach ($data as $k => $v) {
            if (is_array($data)) {
                self::text($v, $str);
            } else {
                $str .= " [" . $type . "]  " . $k . ":" . $v . "\n";
            }
        }
    }
}
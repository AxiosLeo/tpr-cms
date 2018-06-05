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
use tpr\framework\Debug;

require  __DIR__ . '/../traits/Jump.php';

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
        self::init();

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
                continue;
            }
            if ($worker->returnCode() != GEARMAN_SUCCESS) {
                echo "return_code: " . $worker->returnCode() . "\n";
                continue;
            }
        }
    }

    public static function job(GearmanJob $job)
    {
        self::$handle = (string)$job->handle();

        $data = $job->workload();

        $data = self::data($data);

        self::result($data,['datetime'=>date("Y-m-d H:i:s")]);
    }

    protected static function result($result = [], array $header = [])
    {
        if (isset($result['time'])) {
            $result['time'] = time();
        }

        $str =  "-----------------------------------------------------------------------------------\n\n";

        $str = $str . " [handle] " . self::$handle . "\n";

        $str = $str . dump($header,false , 'header');

        $str = $str . dump($result,false , 'data');

        $str .= "-----------------------------------------------------------------------------------\n\n";

        $runtime_path = RUNTIME_PATH . '../gearman/' . date("Ym") . "/";

        if (!file_exists($runtime_path)) {
            if (!mkdir($runtime_path, 0700, true)) {
                return strval(file_exists($runtime_path)) . 'Failed to create folders:' . $runtime_path;
            }
        }

        $log_path = $runtime_path . date("d") . "_gearman.log";

        Debug::save($log_path , $str);

        return true;
    }

}
<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-30 23:39
 */

namespace tpr\command;

use api\tool\lib\ArrayTool;
use library\service\Conf;
use tpr\framework\console\Command;
use tpr\framework\console\Input;
use tpr\framework\console\Output;
use \GearmanWorker;
use \GearmanJob;
use tpr\framework\Debug;

class Gearman extends Command
{
    protected function configure()
    {
        $this->setName('gearman')->setDescription('Gearman Service start');
    }

    protected function execute(Input $input, Output $output)
    {
        $worker = new GearmanWorker();
        $worker->addServers(Conf::get('gearman.servers', '127.0.0.1:4730'));

        $worker->addFunction('job', function (GearmanJob $job) {
            ob_start();
            try {
                $result = Gearman::doJob($job, $handle);
                self::result($result, $handle);
            } catch (\Exception $e) {
                $this->output->error($e->getMessage());
            }

            $output = ob_get_clean();
            $this->output->info($output);
            $job->sendComplete($output);
        });

        $worker->setTimeout(Conf::get('gearman.timeout', '10000'));

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

    public static function doJob(GearmanJob $job, &$handle)
    {
        $handle = (string)$job->handle();

        $data = $job->workload();

        dump("receive data : ", $data);
        $tmp = @json_decode($data, true);
        if (!is_array($tmp)) {
            return dump(Debug::dump($data, false, 'data format error '));
        }
        $data  = ArrayTool::instance($tmp);
        $class = $data->get('class', '');
        if (!class_exists($class)) {
            return dump(Debug::dump($class, false, 'class not exist ! '));
        }
        $method = $data->get('method', '');
        if (!method_exists($class, $method)) {
            return dump(Debug::dump($method, false, 'method not exist ! '));
        }
        $params = $data->get('params', []);

        try {
            return call_user_func_array([$class, $method], [$params]);
        } catch (\Exception $e) {
            return null;
        }
    }

    protected static function result($result = [], $handle = null)
    {
        if (isset($result['time'])) {
            $result['time'] = time();
        }

        $str = "-----------------------------------------------------------------------------------\n\n";

        $str = $str . " [handle] " . $handle . "\n";

        $str = $str . Debug::dump($result, false, 'data');

        $str .= "-----------------------------------------------------------------------------------\n\n";

        echo $str;

        return true;
    }
}
<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-31 00:38
 */

namespace tpr\command\workman;

use library\controller\CommandBase;

class Manager extends CommandBase
{
    protected $script_path;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
        $this->script_path = ROOT_PATH . "library/extend/workman";
    }

    public function start()
    {
        $times    = $this->param->get('times', 1);
        $log_path = $this->param->get('log_path', ROOT_PATH . 'runtime/workman/' . date("Y-m-d") . ".log");
        for ($i = 0; $i < $times; $i++) {
            shell_exec("cd $this->script_path && nohup php worker.php start  > $log_path 2>&1 &");
        }
        $this->output->writeln('start workman');
        $this->output->newLine(1);
    }

    public function status()
    {
        $output = shell_exec("cd $this->script_path && php worker.php status");
        $this->output->writeln($output);
        $this->output->newLine(1);
    }
}
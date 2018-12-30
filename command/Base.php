<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-31 00:24
 */

namespace tpr\command;

use library\controller\CommandBase;
use tpr\framework\console\Command;
use tpr\framework\console\Input;
use tpr\framework\console\Output;

class Base extends Command
{
    protected $action = [];

    protected $container = [];

    protected $command_name;

    protected $desc;

    protected $default_action;

    protected function configure()
    {
        $this->setName($this->command_name)->setDescription($this->desc);
        $this->addArgument('action');
        $this->addArgument('params');
    }

    protected function addAction($action, $class = null)
    {
        if (!in_array($action, $this->action)) {
            array_push($this->action, $action);

        }
        if (!is_null($class)) {
            $this->container[$action] = $class;
        }
    }

    protected function execute(Input $input, Output $output)
    {
        CommandBase::init($input, $output);
        $params = $this->input->getArgument('params');
        if (is_null($params)) {
            $params = [];
        } else {
            $tmp   = explode(',', $params);
            $param = [];
            foreach ($tmp as $t) {
                if (strpos($t, '=') !== false) {
                    list($key, $value) = explode('=', $t);
                    $param[$key] = $value;
                } else {
                    $param[$t] = null;
                }
            }
            $params = $param;
        }
        $this->dispatch($this->input->getArgument('action'), $params);
    }

    protected function dispatch($action = null, $params = [])
    {
        if (!is_null($action) && isset($this->action[$action])) {
            if (isset($this->action[$action])) {
                $action = $this->action[$action];
            } elseif (!in_array($action, $this->action)) {
                $action = null;
            }
        }

        if (is_null($action)) {
            $action = $this->output->choice($this->input, 'select action', $this->action, $this->default_action);
        }

        $this->output->info($action . ' is your choice');
        $this->output->newLine(3);

        $class = isset($this->container[$action]) ? $this->container[$action] : null;

        if (!is_null($class) && class_exists($class)) {
            $this->output->writeln('Class Name : ' . $class);
            $Class = new $class($params);
            call_user_func_array([$Class, $action], []);
        } else {
            $this->output->error($class . ' is not exist');
        }
    }
}
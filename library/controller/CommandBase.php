<?php
/**
 * @author  : axiosleo
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2019-02-19 16:08
 */

namespace library\controller;

use tpr\framework\console\Command;
use tpr\framework\console\Input;
use tpr\framework\console\Output;

class CommandBase extends Command
{
    protected $action = [];

    protected $container = [];

    protected $command_name;

    protected $desc;

    protected $default_action;

    protected $mode = 0;

    protected function configure()
    {
        $this->setName($this->command_name)->setDescription($this->desc);
        $this->addArgument('action');
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
        CommandActionBase::init($input, $output);
        $params = [];
        if ($this->input->hasArgument('params')) {
            $params = $this->input->getArgument('params');
            if (is_null($params)) {
                $params = [];
            } else {
                $tmp   = explode(',', $params);
                $param = [];
                foreach ($tmp as $t) {
                    if (false !== strpos($t, '=')) {
                        list($key, $value) = explode('=', $t);
                        $param[$key] = $value;
                    } else {
                        $param[$t] = null;
                    }
                }
                $params = $param;
            }
        }
        $this->dispatch($this->input->getArgument('action'), $params);
    }

    protected function dispatch($action = null, $params = [])
    {
        if (!empty($this->action)) {

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
                $Class = new $class($params);
                call_user_func_array([$Class, "run"], []);
            } else {
                $this->output->error($class . ' is not exist');
            }
        }
    }
}
<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2019-02-19 22:13
 */

namespace tpr\command;

use library\controller\CommandBase;
use tpr\framework\console\Input;
use tpr\framework\console\Output;

class Index extends CommandBase
{
    protected $command_name = "test";

    protected $desc = "cli command for test";

    public function __construct(string $name = "test")
    {
        parent::__construct($name);
    }

    public function run(Input $input, Output $output)
    {
        dump("hello, world!");
    }
}
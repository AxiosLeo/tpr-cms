<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/5/15 20:14
 */
namespace tpr\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class Index extends Command
{
    protected function configure()
    {
        $this->setName('test')->setDescription('Here is the remark ');
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln("This is TestCommand");
    }
}
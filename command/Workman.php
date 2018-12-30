<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-30 23:53
 */

namespace tpr\command;

class Workman extends Base
{
    protected $command_name = 'workman';

    protected $desc = 'Workerman Service start';

    protected $default_action = 'status';

    public function __construct(string $name = null)
    {
        parent::__construct($name);
        $this->addAction('start', 'tpr\command\workman\Manager');
        $this->addAction('status', 'tpr\command\workman\Manager');
    }
}
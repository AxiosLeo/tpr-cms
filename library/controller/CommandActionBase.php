<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-31 00:23
 */

namespace library\controller;

use api\tool\lib\ArrayTool;
use tpr\framework\console\Input;
use tpr\framework\console\Output;

class CommandActionBase
{
    /**
     * @var Input
     */
    protected $input;

    /**
     * @var Output
     */
    protected $output;

    /**
     * @var ArrayTool
     */
    protected $param;

    private static $inputStatic;

    private static $outputStatic;

    public static function init(Input $input, Output $output)
    {
        self::$inputStatic  = $input;
        self::$outputStatic = $output;
    }

    public function __construct($params = [])
    {
        $this->input  = self::$inputStatic;
        $this->output = self::$outputStatic;
        $this->param  = ArrayTool::instance($params);
    }
}
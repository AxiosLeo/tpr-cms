<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/9/18 下午1:04
 */

namespace library\exception;


class PathNotException extends \RuntimeException
{
    protected $path;

    public function __construct($message , $path = null)
    {
        $this->message = $message;
        $this->path    = $path;
    }

    /**
     * 获取类名
     * @access public
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
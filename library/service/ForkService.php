<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-13 18:02
 */

namespace library\service;

class ForkService
{
    public static    $size     = 0;
    public static    $queue    = [];
    protected static $pid_list = [];
    protected static $max      = 100;

    protected static function check()
    {
        return function_exists('pcntl_fork') && function_exists('posix_kill') && function_exists('ftok') && function_exists('shmop_open');
    }

    public static function doFork($queue = [])
    {
        self::$queue = [];
        $max         = intval(config('app.max_process', 100));
        $max         = $max < 50 ? 50 : $max;
        $max         = $max > 1000 ? 1000 : $max;
        self::$max   = $max;
        foreach ($queue as $q) {
            self::doWork($q['class'], $q['func'], $q['args']);
        }
    }

    protected static function max()
    {
        $pid_size = shell_exec('ps -fe |grep "php-fpm"|grep "pool"|wc -l');
        if ($pid_size >= self::$max) {
            return true;
        }
        return false;
    }

    public static function doWork($class, $func, $args = [])
    {
        if (self::max()) {
            sleep(3);
            self::doWork($class, $func, $args);
        }
        if (is_string($class) && class_exists($class)) {
            $class = new $class();
        }
        if (self::check()) {
            $fork = self::fork();
            if ($fork) {
                return $fork;
            }
            call_user_func_array([$class, $func], $args);
            posix_kill(posix_getpid(), SIGINT);
            exit();
        }
        return false;
    }

    public static function fork($killFather = false)
    {
        if (self::check()) {
            $pid = pcntl_fork();
            if ($pid > 0) {
                pcntl_wait($status);
                if ($killFather) {
                    exit();
                }
                return $pid;
            } else if ($pid == 0) {
                $ppid = pcntl_fork();
                if ($ppid > 0) {
                    posix_kill(posix_getpid(), SIGINT);
                    exit();
                } else if ($ppid == -1) {
                    exit();
                }
                return false;
            } else {
                return false;
            }
        }
        return false;
    }

    public static function work($class, $func, $args = [])
    {
        $queue = [
            'class' => $class,
            'func'  => $func,
            'args'  => $args
        ];
        array_push(self::$queue, $queue);
        return true;
    }
}
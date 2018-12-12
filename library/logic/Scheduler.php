<?php
/**
 * @blog    : https://newt0n.github.io/2017/02/10/PHP-%E5%8D%8F%E7%A8%8B%E5%8E%9F%E7%90%86/
 * @datetime: 2018/8/7 22:02
 */

namespace library\logic;

use \Generator;

class Scheduler
{
    protected $maxTaskId = 0;
    protected $tasks = []; // taskId => task
    protected $queue;
    // resourceID => [socket, tasks]
    protected $waitingForRead = [];
    protected $waitingForWrite = [];

    public function __construct()
    {
        // SPL 队列
        $this->queue = new \SplQueue();
    }

    public function newTask(Generator $coroutine)
    {
        $tid               = ++$this->maxTaskId;
        $task              = new Task($tid, $coroutine);
        $this->tasks[$tid] = $task;
        $this->schedule($task);
        return $tid;
    }

    public function schedule(Task $task)
    {
        // 任务入队
        $this->queue->enqueue($task);
    }

    public function run()
    {
        while (!$this->queue->isEmpty()) {
            // 任务出队
            $task = $this->queue->dequeue();
            $task->run();

            if ($task->isFinished()) {
                unset($this->tasks[$task->getTaskId()]);
            } else {
                $this->schedule($task);
            }
        }
    }

    public function waitForRead($socket, Task $task)
    {
        if (isset($this->waitingForRead[(int)$socket])) {
            $this->waitingForRead[(int)$socket][1][] = $task;
        } else {
            $this->waitingForRead[(int)$socket] = [$socket, [$task]];
        }
    }

    public function waitForWrite($socket, Task $task)
    {
        if (isset($this->waitingForWrite[(int)$socket])) {
            $this->waitingForWrite[(int)$socket][1][] = $task;
        } else {
            $this->waitingForWrite[(int)$socket] = [$socket, [$task]];
        }
    }

    /**
     * @param $timeout 0 represent
     */
    protected function ioPoll($timeout)
    {
        $rSocks = [];
        foreach ($this->waitingForRead as list($socket)) {
            $rSocks[] = $socket;
        }
        $wSocks = [];
        foreach ($this->waitingForWrite as list($socket)) {
            $wSocks[] = $socket;
        }
        $eSocks = [];
        // $timeout 为 0 时, stream_select 为立即返回，为 null 时则会阻塞的等，见 http://php.net/manual/zh/function.stream-select.php
        if (!@stream_select($rSocks, $wSocks, $eSocks, $timeout)) {
            return;
        }
        foreach ($rSocks as $socket) {
            list(, $tasks) = $this->waitingForRead[(int)$socket];
            unset($this->waitingForRead[(int)$socket]);
            foreach ($tasks as $task) {
                $this->schedule($task);
            }
        }
        foreach ($wSocks as $socket) {
            list(, $tasks) = $this->waitingForWrite[(int)$socket];
            unset($this->waitingForWrite[(int)$socket]);
            foreach ($tasks as $task) {
                $this->schedule($task);
            }
        }
    }

    /**
     * 检查队列是否为空，若为空则挂起的执行 stream_select，否则检查完 IO 状态立即返回，详见 ioPoll()
     * 作为任务加入队列后，由于 while true，会被一直重复的加入任务队列，实现每次任务前检查 IO 状态
     * @return Generator object for newTask
     */
    protected function ioPollTask()
    {
        while (true) {
            if ($this->queue->isEmpty()) {
                $this->ioPoll(null);
            } else {
                $this->ioPoll(0);
            }
            yield;
        }
    }

    /**
     * $scheduler = new Scheduler;
     * $scheduler->newTask(Web Server Generator);
     * $scheduler->withIoPoll()->run();
     * 新建 Web Server 任务后先执行 withIoPoll() 将 ioPollTask() 作为任务入队
     * @return $this
     */
    public function withIoPoll()
    {
        $this->newTask($this->ioPollTask());
        return $this;
    }
}

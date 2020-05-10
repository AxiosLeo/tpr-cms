<?php

declare(strict_types=1);

namespace admin\common\controller;

use library\Service;
use Minphp\Session\Session;
use tpr\Container;
use tpr\Controller;
use Twig\Environment;
use Twig\TwigFunction;

class AdminBase extends Controller
{
    /**
     * @var Environment
     */
    protected $templateDriver;

    /**
     * @var Session
     */
    protected $session;

    public function __construct()
    {
        parent::__construct();
        $this->templateDriver = Container::template()->driver();
        $funcList             = include_once __DIR__ . '/../../func.php';
        foreach ($funcList as $name => $func) {
            $this->templateDriver->addFunction(new TwigFunction($name, $func));
        }
        $this->assign('module', Container::dispatch()->getModuleName());
        $this->assign('controller', Container::dispatch()->getControllerName());
        $this->assign('action', Container::dispatch()->getActionName());
        $this->session = Service::session();
        $this->session->start();
    }

    public function __call($name, $arguments)
    {
        if ($this->request->isPost()) {
            $this->response([], 404, 'route not found');
        }

        return $this->fetch('error');
    }

    protected function success($data = [], $url = null)
    {
        $res = [
            'code' => 0,
            'msg'  => 'success',
            'data' => $data,
            'url'  => $url,
        ];
        parent::success($res);
    }

    protected function error($msg = 'Unknown Error', $code = 520)
    {
        $res = [
            'code' => $code,
            'msg'  => $msg,
            'data' => [],
        ];
        parent::response($res);
    }
}

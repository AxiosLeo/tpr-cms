<?php

declare(strict_types = 1);

namespace admin\common\controller;

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
    }

    public function __call($name, $arguments)
    {
        if ($this->request->isPost()) {
            $this->error(404, 'route not found');
        }
        return $this->fetch('error');
    }

    protected function success($data = [])
    {
        $res = [
            'code' => 200,
            'msg'  => 'success',
            'data' => $data
        ];
        parent::success($res);
    }
}

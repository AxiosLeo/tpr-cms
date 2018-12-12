<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-12 14:42
 */

namespace library\controller;

use think\Controller;
use think\Container;
use think\exception\HttpResponseException;
use think\facade\Response;

class BaseController extends Controller
{
    protected $headers = [];

    protected $type = '';

    protected $result = [];

    protected $param;

    public function __construct()
    {
        parent::__construct();
        $this->param = $this->request->param();
    }

    protected function setResponseType($type)
    {
        $this->type = $type;
    }

    protected function setHeader($header_name, $content = '')
    {
        if (is_array($header_name)) {
            $this->headers = array_merge($this->headers, $header_name);
        } else {
            $this->headers[$header_name] = $content;
        }
    }

    protected function setResult($key, $value = '')
    {
        $this->result[$key] = $value;
        return $this;
    }

    protected function wrong($code = 500, $msg = '')
    {
        $this->response([], $code, $msg);
    }

    protected function response($data, $code = 200, $msg = '')
    {
        $this->setResult('code', $code)
            ->setResult('msg', $this->msg($msg))
            ->setResult('time', $_SERVER['REQUEST_TIME'])
            ->setResult('data', $data);
        $config   = Container::get('config');
        $type     = empty($type) ? $config->get('default_ajax_return') : $type;
        $response = Response::create($this->result, $type)->header($this->headers);
        throw new HttpResponseException($response);
    }

    protected function output($output = null, $header = [])
    {
        $this->setHeader($header);

        $response = Response::create($output, 'text')->header($this->headers);

        throw new HttpResponseException($response);
    }

    private function msg($message = '')
    {
        if (empty($message)) {
            $tmp = config('code.' . strval($message), '');
            if (!empty($tmp)) {
                $message = $tmp;
            }
        }
        return $message;
    }

    protected function fetch($template = '', $vars = [], $config = [])
    {
        if (empty($template)) {
            $template = $this->request->action();
        }

        if (strpos($template, ':') === false) {
            $template = strtolower($this->request->module()) . ":" . strtolower($this->request->controller()) . ":" . $template;
        }

        return parent::fetch($template, $vars, $config);
    }
}
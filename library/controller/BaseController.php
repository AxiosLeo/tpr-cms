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

    protected function wrong($code = 500, $msg = '')
    {
        $this->response([], $code, $msg);
    }

    protected function response($data, $code = 200, $msg = '')
    {
        $result   = [
            'code' => $code,
            'msg'  => $this->msg($msg),
            'time' => $_SERVER['REQUEST_TIME'],
            'data' => $data
        ];
        $config   = Container::get('config');
        $type     = empty($type) ? $config->get('default_ajax_return') : $type;
        $response = Response::create($result, $type)->header($this->headers);
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
}
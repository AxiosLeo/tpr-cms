<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/1 下午4:31
 */

namespace library\controller;


use tpr\framework\Controller;
use tpr\framework\Request;

class HomeBase extends Controller
{
    protected $project = PROJECT_NAME;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
        $template = empty($template) ? $this->request->action() : $template;

        if (strpos($template, ':') !== false) {
            $template_dir = $template;
        } else {
            $template_dir = strtolower($this->request->module()) . ":" . strtolower($this->request->controller()) . ":" . $template;
        }

        $config['view_path'] = ROOT_PATH . 'views/' . PROJECT_NAME . '/';
        return parent::fetch($template_dir, $vars, $replace, $config);
    }
}
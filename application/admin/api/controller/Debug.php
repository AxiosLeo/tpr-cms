<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/9/18 下午3:00
 */

namespace tpr\admin\api\controller;

use library\logic\DocLogic;
use tpr\framework\Doc;
use tpr\framework\Env;
use tpr\admin\common\controller\AdminLogin;

class Debug extends AdminLogin
{
    /**
     * 接口调试页
     * @return mixed
     * @throws \tpr\framework\Exception
     */
    public function index()
    {
        $app_namespace = $this->request->param('an', '');
        $class_name = $this->request->param('cn', '');
        $func_name = $this->request->param('fn', '');

        $exception = ['admin'];

        DocLogic::appList(ROOT_PATH . 'application/', $exception);
        $app_map = DocLogic::$appMap;
        $app_map = array_flip($app_map);

        if (!isset($app_map[$app_namespace])) {
            echo "异常错误";
        }

        $app_path = $app_map[$app_namespace];

        DocLogic::doc($app_path);

        $method_doc = Doc::instance()->makeMethodDoc($class_name, $func_name);
        $method_comment = $method_doc['comment'];

        $path = empty($method_doc['route']) ? $method_doc['path'] : $method_doc['route'];
        $this->assign('path', $path);

        $title = data($method_comment, 'title', '未注释');
        $this->assign('title', $title);

        $host = Env::get('api.host', 'http://cms.test.cn/');
        $this->assign('host', $host);

        $parameter = data($method_comment, 'parameter', []);
        $this->assign('param', $parameter);

        $header = data($method_comment, 'header', []);
        $headers = [];
        $n = 0;
        if (is_array($header)) {
            foreach ($header as $h) {
                $h = preg_replace("/[\s]+/is", " ", $h);
                $temp = explode(' ', $h);
                if (isset($temp[0])) {
                    $headers[$n]['name'] = $temp[0];
                    $headers[$n]['value'] = isset($temp[1]) ? $temp[1] : '';
                    $n++;
                }
            }
        } else {
            $h = preg_replace("/[\s]+/is", " ", $header);
            $temp = explode(' ', $h);
            if (isset($temp[0])) {
                $headers[$n]['name'] = $temp[0];
                $headers[$n]['value'] = isset($temp[1]) ? $temp[1] : '';
            }
        }
        $this->assign('headers', $headers);
        return $this->fetch();
    }

    public function post()
    {
        $url = $this->request->param('url', '');
        $params = isset($this->param['params']) ? $this->param['params'] : [];
        $method = $this->request->param('method', 'GET');
        $header = isset($this->param['headers']) ? $this->param['headers'] : [];

        $result = $this->curl($url, $params, $method, $header);
        $this->result($result);
    }

    private function curl($url = '', $data = [], $method = "GET", $header = [])
    {
        $data = is_array($data) ? http_build_query($data) : $data;
        if ($method == "GET") {
            if (strpos($data, '?') === false) {
                $url = $url . "?";
            }
            $lastString = substr($data, -1);
            $url = $lastString == "&" || $lastString == "?" ? $url . $data : $url . "&" . $data;
        }
        curl_init();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 80);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if (is_array($header) && 0 < count($header)) {
            $header = self::getHttpHeaders($header);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        $response = [];
        $body = curl_exec($ch);
        $response['header'] = curl_getinfo($ch, CURLINFO_HEADER_OUT);
        $response['content'] = $body;
        $response['errno'] = curl_errno($ch);
        $response['error'] = curl_error($ch);
        $response['data'] = $data;
        curl_close($ch);

        return $response;
    }

    public static function getHttpHeaders($headers)
    {
        $httpHeader = [];
        foreach ($headers as $key => $value) {
            array_push($httpHeader, $key . ":" . $value);
        }
        return $httpHeader;
    }
}
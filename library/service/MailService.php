<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/3/19 13:46
 */

namespace library\service;

use PHPMailer\PHPMailer\PHPMailer;
use tpr\framework\Config;

class MailService extends PHPMailer
{
    /**
     * @var $this
     */
    private static $instance;

    private static $config = [
        'is_smtp'    => true,
        'host'       => 'smtp.qq.com',
        'port'       => 465,
        'smtp_auth'  => true,
        'username'   => '',
        'password'   => '',
        'email'      => '',
        'from_name'  => '',
        'smtp_secure'=> 'ssl',
        'char_set'   => 'UTF-8'
    ];

    public static function mail($config = 'default', $isHtml = true, $debug = false)
    {
        if (is_string($config)) {
            $config = Config::get('mail.' . $config, []);
            self::$config = array_merge(self::$config,$config);
        }else if(is_array($config)){
            self::$config = array_merge(self::$config,$config);
        }

        $config = self::$config;

        self::$instance = new self();

        if (isset($config['is_smtp']) && $config['is_smtp']) {
            self::$instance->isSMTP();
            self::$instance->SMTPAuth = true;
        }

        if ($debug) {
            self::$instance->SMTPDebug = 1;
        }

        //smtp服务器地址
        self::$instance->Host = $config['host'];

        //设置ssl连接smtp服务器的远程服务器端口号
        self::$instance->Port = $config['port'];
        self::$instance->SMTPAuth = $config['smtp_auth'];

        //设置使用ssl加密方式登录鉴权
        self::$instance->SMTPSecure = $config['smtp_secure'];

        //smtp登录的账号
        self::$instance->Username = $config['username'];

        //smtp登录的密码
        self::$instance->Password = $config['password'];

        //设置发件人邮箱地址
        self::$instance->From = empty($from) ? $config['email'] : $from;
        self::$instance->FromName = $config['from_name'];

        if ($isHtml) {
            //邮件正文是否为html编码
            self::$instance->isHTML(true);
        }

        //设置发送的邮件的编码
        self::$instance->CharSet = $config['char_set'];
        return self::$instance;
    }

    public function setContent($subject, $body, $altBody = '')
    {
        self::$instance->Subject = $subject;
        self::$instance->Body = $body;
        if (!empty($altBody)) {
            self::$instance->AltBody = $altBody;
        }
        return self::$instance;
    }
}
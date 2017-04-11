<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/11 14:41
 */
namespace app\common\service;
use PHPMailer;
use think\Config;

class MailService {
    private static $debug = false;

    public static function mail($select = 'default',$from='',$isHtml=true){
        $config = Config::get('mail.'.$select);
        if(empty($config)){
            return false;
        }
        $mail = new PHPMailer();
        if(isset($config['is_smtp']) && $config['is_smtp']){
            $mail->isSMTP();
            $mail->SMTPAuth = true;
        }
        if(self::$debug){
            $mail->SMTPDebug = 1;
        }

        //smtp服务器地址
        $mail->Host       = $config['host'];
        //设置ssl连接smtp服务器的远程服务器端口号
        $mail->Port       = $config['port'];
        $mail->SMTPAuth   = $config['smtp_auth'];
        //设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = $config['smtp_secure'];
        //smtp登录的账号
        $mail->Username   = $config['username'];
        //smtp登录的密码
        $mail->Password   = $config['password'];

        //设置发件人邮箱地址
        $mail->From       = empty($from)?$config['email']:$from;
        $mail->FromName   = $config['from_name'];

        if($isHtml){
            //邮件正文是否为html编码
            $mail->isHTML(true);
        }

        //设置发送的邮件的编码
        $mail->CharSet = $config['char_set'];
        return $mail;
    }

    public static function mailContent(PHPMailer $mail,$subject,$body,$altBody=''){
        $mail->Subject = $subject;
        $mail->Body = $body;
        if(!empty($altBody)){
            $mail->AltBody = $altBody;
        }
        return $mail;
    }
}
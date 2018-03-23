<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/12/25 16:07
 */

namespace tpr\wechat\index\controller;

use library\controller\WechatBase;
use library\logic\UserLogic;
use think\Cache;
use think\Db;
use think\Request;
use think\Session;

class Auth extends WechatBase
{
    protected $state ;

    protected $host ;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->state = $this->config['state'];
        $this->host  = $this->request->host();
    }

    public function auth(){
        $authRedirect = $this->Oauth->getOauthRedirect(
            url('index/auth/authCallback', ['redirect'=>base64_encode($this->redirect)],'',$this->host), $this->state,"snsapi_userinfo"
        );
        $this->redirect($authRedirect);
    }

    /**
     * @return int|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function authCallback()
    {
        if($this->param['state'] === $this->state){
            $result = $this->Oauth->getOauthAccessToken();
            if(is_array($result)){
                Cache::set('access_token',$result['access_token'],7000);
                Cache::set('refresh_token',$result['refresh_token']);
            }else{
                $this->assign('msg', '微信服务异常,请稍后重试');

                return $this->fetch(":result");
            }

            $openid = $result['openid'];

            $wechatInfo = $this->Oauth->getOauthUserInfo($result['access_token'],$openid);

            if(!empty($wechatInfo)){
                $insert = [
                    'wechat'=>$this->wechat,
                    'nickname'=>$wechatInfo['nickname'],
                    'sex'=>$wechatInfo['sex'],
                    'headimgurl'=>$wechatInfo['headimgurl'],
                    'unionid'=>isset($wechatInfo['unionid'])?$wechatInfo['unionid']:"",
                    'openid'=>$wechatInfo['openid']
                ];
                Db::name('wx_userinfo')->insert($insert,true);
            }

            Session::set('wechat_info',$wechatInfo , PROJECT_NAME);

            UserLogic::getUserInfoByOpenId($wechatInfo['openid'],$this->wechat);

            $this->redirect($this->redirect);
        }
        return 0;
    }

    public function api(){
        //1. 将timestamp , nonce , token 按照字典排序
        $timestamp = $this->request->param('timestamp','');
        $nonce = $this->request->param('nonce','');
        $token = $this->config['token'];
        $signature = $this->request->param('signature','');
        $array = array($timestamp,$nonce,$token);
        sort($array);

        //2.将排序后的三个参数拼接后用sha1加密
        $str = implode('',$array);
        $str = sha1($str);

        //3. 将加密后的字符串与 signature 进行对比, 判断该请求是否来自微信
        if($str == $signature)
        {
            echo $this->request->param('echostr','echostr');
        }
        die();
    }
}
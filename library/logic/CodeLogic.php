<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/1/16 16:39
 */

namespace library\logic;

use library\service\RedisService;
use think\Exception;
use think\Tool;

/**
 * 兑换码批量生成逻辑类
 * @package library\logic
 */
class CodeLogic
{
    /**
     * @var CodeLogic
     */
    private static $instance;

    private static $minCode;

    private static $maxCode;

    private static $number;

    private static $ticket_length = 4;

    private static $encoding_length = 12;

    private static $category_uniq;

    public static function instance(){
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setMinCode($minCode){
        self::$minCode = $minCode;
        return self::$instance;
    }

    public function setMaxCode($maxCode){
        self::$maxCode = $maxCode;
        return self::$instance;
    }

    public function setNumber($number){
        self::$number = $number;
        return self::$instance;
    }

    public function setTicketLength($ticket_length){
        self::$ticket_length = $ticket_length;
        return self::$instance;
    }

    public function setCategoryUniq($category_uniq){
        self::$category_uniq = $category_uniq;
        return self::$instance;
    }

    /**
     * @param $category_uniq
     * @param $number
     * @param $ticket_length
     * @param $encoding_length
     * @throws Exception
     */
    protected function check($category_uniq, $number, $ticket_length, $encoding_length){
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        self::$category_uniq   = empty($category_uniq) ? self::$category_uniq : $category_uniq;
        self::$number          = empty($number) ? self::$number : $number;
        self::$ticket_length   = is_null($ticket_length) ? self::$ticket_length : $ticket_length;
        self::$encoding_length = is_null($encoding_length) ? self::$encoding_length : $encoding_length;

        if(empty(self::$category_uniq)){
            throw new Exception("category_uniq is empty");
        }

        if(!is_numeric(self::$number) || !is_numeric(self::$ticket_length) || !is_numeric(self::$encoding_length)){
            throw new Exception("param format is wrong");
        }
    }


    /**
     * 批量生成兑换码
     * @param string $category_uniq 兑换码类目唯一标识
     * @param int $number 兑换码生成个数
     * @param int $ticket_length 票码长度
     * @param int $encoding_length 随机字符长度
     * @return array 兑换码列表
     * @throws Exception
     */
    public function create($category_uniq = '' , $number = 0, $ticket_length = null, $encoding_length = null)
    {
        self::check($category_uniq, $number, $ticket_length, $encoding_length);
        unset($category_uniq,$number,$ticket_length,$encoding_length);

        list($min, $max) = self::countBase(self::$ticket_length);
        $ticket = self::ticket(self::$category_uniq, $min);
        if ($ticket + self::$number > $max) {
            return self::create(self::$category_uniq, self::$number, ++self::$ticket_length);
        }
        $time = time();
        $list = [];
        $n = 0;

        for ($i = 0; $i < self::$number; $i++) {
            $ticket = self::ticket(self::$category_uniq, $min);
            $ticket = ConvertLogic::convert($ticket,10,62);
            $encoding = self::encoding(self::$category_uniq, $ticket);
            $data = [
                'category_uniq' => self::$category_uniq,
                'ticket'        => $ticket,
                'encoding'      => $encoding,
                'created_at'    => $time,
                'status'        => 0
            ];
            $list[$n++] = $data;
        }

        return $list;
    }

    /**
     * 一个兑换码领一张票
     * @param $category_uniq
     * @param int $baseCount
     * @return mixed
     */
    private static function ticket($category_uniq, $baseCount)
    {
        $key = 'code_ticket_' . $category_uniq;
        RedisService::redis()->switchDB()->watch($key);

        $ret = RedisService::redis()->switchDB()->multi()
            ->incr($key)
            ->exec();

        if ($ret === false) {
            RedisService::redis()->switchDB()->unwatch();
            RedisService::redis()->switchDB()->discard();
            return self::ticket($category_uniq, $baseCount);
        }
        $count = $ret[0];
        $ticket = $baseCount + $count;

        return $ticket;
    }

    /**
     * 票码长度对应的基础计数值和计数最大值
     * @param int $length 票码长度
     * @return array
     */
    private static function countBase($length = 4)
    {
        if(!empty(self::$minCode)){
            $min = self::$minCode;
        }else{
            $min = "1";
            for ($i = 0; $i < $length - 1; $i++) {
                $min = $min . "0";
            }
        }
        $min = ConvertLogic::convert($min, 62, 10);

        if(!empty(self::$maxCode)){
            $max = self::$maxCode;
        }else{
            $max = "";
            for ($i = 0; $i < $length; $i++) {
                $max = $max . "Z";
            }
        }
        $max = ConvertLogic::convert($max, 62, 10);

        return [intval($min), intval($max)];
    }

    /**
     * 生成单个兑换码
     * @param $category_uniq
     * @param $ticket
     * @return string
     */
    private static function encoding($category_uniq, $ticket)
    {
        $code = $ticket . Tool::getRandChar( self::$encoding_length);
        $key = 'code_hash_list_' . $category_uniq;
        $result = RedisService::redis()->switchDB()->hSetNx($key, $code, $ticket);
        if ($result === false) {
            self::encoding($category_uniq, $ticket);
        }
        return $code;
    }
}
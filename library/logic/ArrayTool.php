<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018/8/2 09:51
 */

namespace library\logic;


/**
 * 数组操作类
 * @desc 支持任意层级子元素的增删改查
 * @package library\logic
 */
class ArrayTool
{
    public static function array($array = [])
    {
        return new self($array);
    }

    private $array;

    public function __construct($array)
    {
        $this->array = $array;
    }

    /**
     * 设置任意层级子元素
     * @param string|array|int $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        if (is_array($key)) {
            $this->array = array_merge($this->array, $key);
        } else {
            if (false === strpos($key, '.')) {
                $this->array[$key] = $value;
            } else {
                $keyArray    = explode('.', $key);
                $this->array = $this->recurArrayChange($this->array, $keyArray, $value);
            }
        }
    }

    /**
     * 获取任意层级子元素
     * @param null|string|int $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->array;
        }

        if (false === strpos($key, '.')) {
            return isset($this->array[$key]) ? $this->array[$key] : $default;
        }

        $keyArray = explode('.', $key);
        $tmp      = $this->array;
        foreach ($keyArray as $k) {
            if (isset($tmp[$k])) {
                $tmp = $tmp[$k];
            } else {
                $tmp = $default;
                break;
            }
        }
        return $tmp;
    }

    /**
     * 删除任意层级子元素
     * @param string|array|int $key
     */
    public function delete($key)
    {
        if (is_array($key)) {
            foreach ($key as $k) {
                $this->set($k, null);
            }
        } else {
            $this->set($key, null);
        }
    }

    /**
     * 获取某一节点下的子元素key列表
     * @param $key
     * @return array
     */
    public function getChildKeyList($key)
    {
        $child = $this->get($key);
        $list  = [];
        $n     = 0;
        foreach ($child as $k => $v) {
            $list[$n++] = $k;
        }
        return $list;
    }

    /**
     * 递归遍历
     * @param array $array
     * @param array $keyArray
     * @param mixed $value
     * @return array
     */
    private function recurArrayChange($array, $keyArray, $value = null)
    {
        $key0 = $keyArray[0];
        if (is_array($array) && isset($keyArray[1])) {
            unset($keyArray[0]);
            $keyArray = array_values($keyArray);
            if (!isset($array[$key0])) {
                $array[$key0] = [];
            }
            $array[$key0] = $this->recurArrayChange($array[$key0], $keyArray, $value);
        } else {
            if (is_null($value)) {
                unset($array[$key0]);
            } else {
                $array[$key0] = $value;
            }
        }
        return $array;
    }
}
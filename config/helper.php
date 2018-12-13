<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-12 14:11
 */

if (!function_exists('data')) {
    function data($data, $index, $default = '')
    {
        return isset($data[$index]) ? $data[$index] : $default;
    }
}

if (!function_exists('c')) {
    function c($index, $default = null)
    {
        return \think\facade\Config::has($index) ? \think\facade\Config::get($index) : $default;
    }
}

if (!function_exists('get_day_begin_end_time')) {
    function get_day_begin_end_time($date, $format = 'timestamp')
    {
        $begin = strtotime($date . " 00:00:00");
        $end   = strtotime("$date +1 day -1 seconds");
        if ($format == 'timestamp') {
            return [
                'begin' => $begin,
                'end'   => $end
            ];
        } else {
            return [
                'begin' => date($format, $begin),
                'end'   => date($format, $end),
            ];
        }
    }
}

if (!function_exists('trans2time')) {
    function trans2time($timestamp, $format = "Y-m-d H:i:s", $default = '')
    {
        $result = !empty($timestamp) ? @date($format, $timestamp) : $default;

        return $result != "1970-01-01 08:33:37" ? $result : '';
    }
}

if (!function_exists('getDayBeginEndTime')) {
    function getDayBeginEndTime($date, $format = 'timestamp')
    {
        $begin = strtotime($date . " 00:00:00");
        $end   = strtotime("$date +1 day -1 seconds");
        if ($format == 'timestamp') {
            return [
                'begin' => $begin,
                'end'   => $end
            ];
        } else {
            return [
                'begin' => date($format, $begin),
                'end'   => date($format, $end),
            ];
        }
    }
}

if (!function_exists('tpr_infinite_tree')) {
    /**
     * 无限层级的生成树方法
     *
     * @param        $data
     * @param string $parent_index
     * @param string $data_index
     * @param string $child_name
     *
     * @return array|bool
     */
    function tpr_infinite_tree($data, $parent_index = 'parent_id', $data_index = 'id', $child_name = 'child')
    {
        $items = [];
        foreach ($data as $d) {
            $items[$d[$data_index]] = $d;
            if (!isset($d[$parent_index]) || !isset($d[$data_index]) || isset($d[$child_name])) {
                return false;
            }
        }
        $tree = [];
        $n    = 0;
        foreach ($items as $item) {
            if (isset($items[$item[$parent_index]])) {
                $items[$item[$parent_index]][$child_name][] = &$items[$item[$data_index]];
            } else {
                $tree[$n++] = &$items[$item[$data_index]];
            }
        }
        return $tree;
    }
}

if (!function_exists('traversal_tree_to_node_list')) {
    /**
     * 遍历生成树，生成节点列表
     *
     * @param        $tree
     * @param array  $data
     * @param int    $layer
     * @param string $layer_name
     * @param string $child_name
     */
    function traversal_tree_to_node_list($tree, &$data = [], $layer = 0, $layer_name = 'layer', $child_name = 'child')
    {
        foreach ($tree as $t) {
            $node = $t;
            unset($node[$child_name]);
            $node[$layer_name] = $layer;
            $data[]            = $node;
            if (isset($t[$child_name]) && !empty($t[$child_name])) {
                traversal_tree_to_node_list($t[$child_name], $data, $layer + 1);
            }
        }
    }
}

if (!function_exists('u')) {
    function u($module = '', $controller = '', $action = '')
    {
        return url($module . '/' . $controller . '/' . $action);
    }
}

if (!function_exists('dd')) {
    function dd($data, $label = null, $echo = true)
    {
        return dump($data, $echo, $label);
    }
}
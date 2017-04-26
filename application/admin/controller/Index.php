<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/25 15:43
 */
namespace app\admin\controller;

use app\common\controller\HomeLogin;
use Phpml\Classification\KNearestNeighbors;

class Index extends HomeLogin {
    public function index(){
        $samples = [[1, 3], [2, 1], [2, 4], [3, 1], [4, 1], [4, 2]];
        $labels = ['a', 'a', 'a', 'b', 'b', 'b'];

        $classifier = new KNearestNeighbors();
        $classifier->train($samples, $labels);

        $test = $classifier->predict([3, 2]);
        dump($test);
        $test = $classifier->predict([3, 4]);
        dump($test);
//        return $this->fetch('index');
    }
}
<?php
namespace app\index\controller;

use axios\tpr\controller\ApiBase;
use axios\tpr\service\ApiDocService;
use axios\tpr\service\MongoService;

/**
 * 接口类名
 * @desc 接口类描述
 * @package app\index\controller
 */
class Index extends ApiBase
{
    /**
     * 接口名称
     * @desc 接口描述
     * @method post | get
     * @parameter 参数类型 参数名称
     * @response string param_name param_info
     */
    public function index()
    {
        $data = [
            "mission"=>[
                "title"=>"part a",
                "file_url"=>"",
                "timestamp"=>"124545126",
                "datetime"=>"2017-05-15 12:33:00"
            ],
            "point"=>[
                [
                    "label"=>"知识点1",
                    "point_type"=>"single",
                    "point_id"=>"asdfdsfdas",
                    "x"=>"1.23",
                    "y"=>"2.34",
                    "w"=>"100",
                    "h"=>"100",
                    "gif"=>[
                        ["file_name"=>"1.gif","start"=>"input"],
                        ["file_name"=>"2.gif","start"=>"input"],
                    ],
                    "mp3"=>[
                        "label"=>"",
                        "file_name"=>""
                    ]
                ],
                [
                    "label"=>"知识点2",
                    "point_type"=>"normal",
                    "point_id"=>"",
                    "x"=>"1.23",
                    "y"=>"2.34",
                    "w"=>"100",
                    "h"=>"100",
                    "gif"=>[
                        ["file_name"=>"1.gif","start"=>"input"],
                        ["file_name"=>"2.gif","start"=>"input"],
                    ],
                    "mp3"=>[
                        "label"=>"",
                        "file_name"=>""
                    ]
                ]
            ]
        ];
        $this->response(["hello world!"]);
    }

    /**
     * hello
     * @desc 测试接口
     * @method get
     */
    public function hello()
    {
        $this->response(['hello'=>"world",'test'=>"a"]);
    }

    public function doc(){
        $this->response(ApiDocService::api());
    }

    public function test(){
        $this->response(['name'=>$this->param['name']]);
    }

    public function mongo(){
        $Mongo = MongoService::name('test');
        dump($Mongo);

        $data = $Mongo->select();
        dump($data);

        $Mongo->insertGetId(['timestamp'=>"123"]);
        dump($Mongo->select());

        $Mongo->where('timestamp',"123")->delete();
        dump($Mongo->select());
    }
}
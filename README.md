基于thinkphp5的restful接口框架---TPR
===============


## 前言
> 之前有用过phalapi和laravel5.3开发过接口，个人感觉都不是很称心称手，正好今天下午没什么事儿，用thinkphp5写了个通用的接口框架。代码量不多，重在代码逻辑设计。不过，虽然比较轻量，但是该有的基础功能也都有了，因为tp5是有composer的，需要扩展一些功能也比较方便。

## Github地址
> [AxiosCros/thinkphp5-restfulapi](https://github.com/AxiosCros/thinkphp5-restfulapi.git)

## 使用文档

### 根目录下创建.env文件
``` shell
cp .env.example .env

[debug]
status = true  #调试模式
# 当debug.status为false时(生产环境)，出现任何错误后都不再打印任何错误信息，而是会回调一个json数组，例如：
{"code":"500","message":"something error","data":[]}
#此举是考虑到当服务端出问题报错后，一堆错误信息会影响客户端正常运行,而且错误信息在生成环境中暴露也不安全
```

### 路由配置
> 此步可以参考thinkphp5的文档[《路由模式》](http://www.kancloud.cn/manual/thinkphp5/118019)

### 接口参数配置
> 配置文件地址 ： /config/extra/filter.php
> 其中validate参数为必须的，其它参数为非必须，占时仅支持validate，scene和mobile参数
> 配置好filter的validate后，需要创建相应的Validate类
> Validate的具体使用方法参考thinkphp5文档的[《验证器》](http://www.kancloud.cn/manual/thinkphp5/129352)
``` php
<?php
//配置举例

//route name
'hello'=>['validate'=>'Hello','scene'=>'scene-name','mobile'=>false],  //针对路由名称的参数过滤

//path
'index/index/index'=>['validate'=>'Hello','scene'=>'scene-name','mobile'=>false] //针对访问地址的参数过滤
    
```

### 定义接口回调状态码
> 配置文件地址 ： /config/extra/code.php

### 多语言
> 语言文件地址 ： /application/lang/zh-cn.php
> thinkphp5文档传送门[《多语言》](http://www.kancloud.cn/manual/thinkphp5/118132)

### 接口输出
``` php
<?php

//回调格式
{"code":"400","data":[],"message":"名称最多不能超过25字符"}

//正常输出 , 具体可参见 index模块/index控制类/index方法
$this->response("some string");
$this->response(['name'=>"test"]);

//异常输出
$this->wrong(406,"这里填写回调提示信息，非必须");  //传入值必须为已定义的状态码
```




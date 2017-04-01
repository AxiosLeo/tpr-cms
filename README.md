基于thinkphp5的restful接口框架---TPR
===============


## 前言
> 之前有用过phalapi和laravel5.3开发过接口，个人感觉都不是很称心称手，正好今天下午没什么事儿，用thinkphp5写了个通用的接口框架。代码量不多，重在代码逻辑设计。不过，虽然比较轻量，但是该有的基础功能也都有了，因为tp5是有composer的，需要扩展一些功能也比较方便。

> 交流QQ群：521797692

> 项目刚刚创建，欢迎PR  ^_^ 

## Github地址
> [AxiosCros/thinkphp5-restfulapi](https://github.com/AxiosCros/thinkphp5-restfulapi.git)

## 特点
* 基于thinkphp5开发，无缝衔接thinkphp5的功能，加速开发速度
* 支持路由和path模式
* 接口配置可以定制化设置接口
* 接口参数验证，可以在一定程度上保证接口访问的标准性
* 通过使用前置和后置中间件，可以有非常好的扩展性
* 接口缓存，可以非常方便的加速接口请求速度
* 状态码对应的message支持多语言翻译，可以很方便的在中英文等多语言环境中切换

## 使用文档

### thinkphp5安装
``` shell
#项目根目录下执行
composer install
```

### 根目录下创建.env文件
``` shell
cp .env.example .env

[debug]
status = true  #调试模式
# 当debug.status为false时(生产环境)，出现任何错误后都不再打印任何错误信息，而是会回调一个json数组，例如：
{"code":"500","message":"something error","data":[]}
#此举是考虑到当服务端出问题报错后(比如路由不存在)，一堆的错误信息会影响客户端正常运行,而且错误信息在生产环境中暴露也不安全
```

### 路由配置
> 此步可以参考thinkphp5的文档[《路由模式》](http://www.kancloud.cn/manual/thinkphp5/118019)

### 接口配置

> 配置文件地址 ： /config/extra/filter.php
> 每一条filter的键值可以为路由名，也可以是访问path

* validate(必须)
  > validate的值是验证器的类名，需要创建相应的Validate类
  > Validate的具体使用方法参考thinkphp5文档的[《验证器》](http://www.kancloud.cn/manual/thinkphp5/129352)
  
* scene (非必须)
  > 验证场景的名称

* mobile (非必须)
  > 是否只允许移动端访问，true为仅允许移动端访问 ,值为false或无该参数 代表所有客户端均可访问

* cache (非必须)
  > 接口缓存，值为缓存有效期(单位秒，值不能为0，为0则不缓存)，同一个访问，当请求内容相同时，直接回调,不进行后续逻辑操作，包括中间件和控制器等等。
  
  > 缓存配置可以在/config/config.php配置文件中修改，建议使用redis做缓存，文件缓存会占用磁盘IO,而磁盘的IO性能比内存可差多了。
  
  > 适用场景：比如当客户端请求时，需要获取一堆数据，而这些数据是通过各种逻辑东拼西凑而成的，耗时可能较长。
  >而有了接口缓存，那么就可以在请求相同时，直接回调数据而不用再进行一系列逻辑操作，节省客户端请求时间。
  
  > 注意：在开发环境，即.env中debug的status为true的情况下，接口缓存无作用。当请求参数过多时，不建议使用接口缓存。


``` php
<?php
//配置举例
//其中validate的值是验证器的类名,scene的值是验证场景,mobile代表此次访问是否只允许移动端访问

//route name
'hello'=>['validate'=>'Hello','scene'=>'scene-name','mobile'=>false,'cache'=>300],  //针对路由名称的参数过滤

//path name
'index/index/index'=>['validate'=>'Hello','scene'=>'scene-name','mobile'=>false] //针对访问地址的参数过滤

```

### 定义接口回调状态码
> 配置文件地址 ： /config/extra/code.php

``` php
//状态码对应的提示信息会根据多语言的设置进行翻译, 具体可查看多语言内容
return [
    //system code , Don't delete .
    "200"=>"success",
    "500"=>"server error",
    "400"=>"arguments error",
    "406"=>"wrong item"
];
```

### 多语言
> 语言文件地址 ： /application/lang/zh-cn.php
> thinkphp5文档传送门[《多语言》](http://www.kancloud.cn/manual/thinkphp5/118132)

### 接口输出
``` php
<?php

//回调格式
{"code":"400","data":[],"message":"名称最多不能超过25字符"}

//正常输出(无需return) , 具体可参见 index模块/index控制类/index方法
$this->response("some string");
$this->response(['name'=>"test"]);

//异常输出
$this->wrong(406,"这里填写回调提示信息，非必须");  //传入值必须为已定义的状态码
$this->wrong(406); // 会返回状态码对应message

//为了避开tp自有的success和error方法，这里采用的是response和wrong命名
```

### 中间件
> 中间件配置文件地址： /config/extra/middleware.php

* 前置中间件
> 该类中间件在验证器(filter)之后和控制器(controller)操作之间执行

* 后置中间件
> 该类中间件在请求后继续执行，且不占用请求时间。

> 可以试想一下这样的一个场景，当从客户端收到一个请求后，要给50个Client发送微信推送消息，由于逻辑非常复杂，需要大约50秒的时间才能完成。

> 这段时间客户端肯定是等不起的，那么就可以先返回一个code=200的请求给客户端，然后用后置中间件完成接下来的操作，这样既不占用客户端的请求时间，也能达到需求的目的，可谓两全其美。

> 使用建议：因为后置中间件在访问结束后会继续占用php-fpm子进程，建议在php-fpm.conf配置文件，将pm.max_children(最大子进程数量)调的多一些。后置中间件处理结束后，会释放子进程。

* 具体使用方法

> 首先要在中间件配置文件中定义中间件，配置示例如下：

``` php
<?php
return [
    //before the request
    'before'=>[
        'hello'=>['middleware'=>'Hello','func'=>'before']
    ],

    //after the request and It's not take the request time.
    'after'=>[
        'hello'=>['middleware'=>'Hello','func'=>'after']
    ]
];
```

> 其中before中的为前置中间件，after中的为后置中间件，middleware中的值为中间件的类名，func中的值为中间件类中的方法function(默认为index)

> middleware类可放置在/application/common/middleware目录下，也可以放置在模块目录下的middleware目录下

> middleware比较独立，可以继承thinkphp自有的类，比如think/Controller或者think/Model等等，当然，也可以不继承。

## 计划上线功能
* 权限认证
* 后台管理系统：管理接口及查看接口文档，可视化查看接口访问数据(如访问次数等)

## 开源协议
> 遵循Apache2开源协议发布，并提供免费使用。
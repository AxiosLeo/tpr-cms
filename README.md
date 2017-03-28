## 前言
> 之前有用过phalapi和laravel5.3开发过接口，个人感觉都不是很称心称手，正好今天下午没什么事儿，用thinkphp5写了个通用的接口框架。代码量不多，重在代码逻辑设计。不过，虽然比较轻量，但是该有的基础功能也都有了，因为tp5是有composer的，需要扩展一些功能也比较方便。

## Github地址
> [AxiosCros/thinkphp5-restfulapi](https://github.com/AxiosCros/thinkphp5-restfulapi.git)

## 使用

### config.php配置
> 再开发开发接口前有一些重要的配置需要做

``` php
'deny_module_list'       => ['common'],  // common木块禁止访问
'exception_handle'       => '\\app\\common\\exception\\Http',  // 自定义异常处理
'default_lang'           => 'zh-cn',  //设置默认语言
```

### 根目录下创建.env文件
``` shell
cp .env.example .env

[debug]
status = true  #调试模式
# 当debug.status为false时，tp不再打印任何错误信息，会直接回调一个json数组，例如：
{"code":"500","message":"something error","data":[]}

```

### 路由配置
> /config/route.php

### 接口参数配置
> /config/extra/filter.php
> 其中validate为必须的，其它参数为非必须，占时仅支持validate，scene和mobile参数
> 配置好filter的validate后，需要创建相应的Validate类

### 接口回调状态码
> /config/extra/code.php

### 多语言
> /application/lang/zh-cn.php

### 接口输出
``` php
<?php

//正常输出
$this->response("some string");
$this->response(['name'=>"test"]);

//异常输出
$this->wrong(406);  //传入值必须为已定义的状态码
```



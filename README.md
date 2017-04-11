基于thinkphp5的restful接口框架---TPR
===============

[![Latest Unstable Version](https://github.com/AxiosCros/thinkphp5-restfulapi/last_version.svg)](https://codeload.github.com/AxiosCros/thinkphp5-restfulapi/zip/master)
[![License](https://github.com/AxiosCros/thinkphp5-restfulapi/license.svg)](https://packagist.org/packages/laravel/framework)


> 之前有用过phalapi和laravel5.3开发过接口，个人感觉都不是很称心称手，就用thinkphp5写了个通用的接口框架。

> 专为接口开发而设计

> 交流QQ群：521797692

## Github地址
> [AxiosCros/thinkphp5-restfulapi](https://github.com/AxiosCros/thinkphp5-restfulapi.git)

## 文档地址
> [看云：《TPR接口开发框架使用文档》](http://www.kancloud.cn/axios/tpr)

> 目前文档还在编写中，待完成

## 项目简介
> [个人博客：《基于thinkphp5的restful接口框架---TPR》](https://hanxv.cn/archives/88.html)

## 框架功能点
* 基于thinkphp5开发，无缝衔接thinkphp5的功能，加快开发速度
* 便捷的接口参数验证，可以在一定程度上保证接口访问的标准性
* 通过使用前置和后置中间件，可以有非常好的扩展性
* 接口缓存，可以非常方便的加速接口请求速度，例如缓存请求5分钟,只需在filter中配置cache=>300即可
* 状态码对应的message支持多语言翻译，可以很方便的在中英文等多语言环境中切换
* 方便接口开发的功能服务类，如MongoService,MailService等
* 具有签名验证和令牌验证等功能

## 开源协议
> 遵循Apache2开源协议发布，并提供免费使用。
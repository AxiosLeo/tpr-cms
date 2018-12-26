基于TPR的后台管理系统
===============

> 前端页面基于layui2.0开发，后端逻辑基于tpr-framework框架核心开发

> 交流QQ群：521797692

> github: [TPR-CMS](https://github.com/AxiosCros/tpr-cms)

## TPR 版本

 * 使用tpr-framework内核的版本   [mater分支](https://github.com/AxiosCros/tpr-cms/tree/master)
    > tpr-framework是基于thinkphp5.0.9开发的版本，与tp官方内核命名空间不同。使用方法参考tp5.0版本内核。
    > 核心地址： [github.com/AxiosCros/tpr-framework](https://github.com/AxiosCros/tpr-framework)
 * 使用tp5.1内核的版本  [think5.1分支](https://github.com/AxiosCros/tpr-cms/tree/think5.1)
    > 因为官方版的tp5.1内核不支持多应用的模式，跟流年沟通过后，也依然不准备支持。
      所以，这一版的内核是fork了tp5.1内核以后修改了五行代码的版本。
      不影响原生功能，请放心使用。以后有新版本发布的话，我会重新fork，然后修复五行代码后跟进发布。
    > 核心地址： [github.com/AxiosCros/framework](https://github.com/AxiosCros/framework)


## tpr-cms后台管理系统所需环境
* php7.0+ 
* php-fpm 
* pcntl
* posix 
* mysql5.5+
* redis , phpredis
* mongodb


## 集成组件或服务

- gearman
- rabbitMQ
- workman
- aliyun-sdk
- PHPMail
- Umeng
- Base Class of Wechat Development
- Admin System
- API example

## 安装
* github
> git clone https://github.com/AxiosCros/tpr-cms.git

* oschina
> git clone https://git.oschina.net/AxiosCro/tpr-cms.git

* coding
> git clone https://git.coding.net/axios/tpr-cms.git

``` shell
cd tpr-cms
composer install --no-dev
cp .env.example .env

#编辑.env文件
vim .env

#手动导入api.sql至数据库
#api.sql中主要是一些后台管理系统会用到的数据表,另外还有一个api_users的用户示例表

```

## 访问
* 接口
 > http://domain/api.php
 
* 管理系统
 > http://domain/index.php
 
 > admin
 
 > 123456
 
* 演示版(非最新版)
 
 > [http://cms.hanxv.cn](http://cms.hanxv.cn)

## ApiDoc
 > [apidoc.gitee.com/AxiosCro/tpr-cms](https://apidoc.gitee.com/AxiosCro/tpr-cms)

## 开源协议
> 遵循Apache2开源协议发布，并提供免费使用
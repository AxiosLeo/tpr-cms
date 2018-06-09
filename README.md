基于TPR的后台管理系统
===============

> 前端页面基于layui2.0开发，后端逻辑基于tpr-framework框架核心开发

> 交流QQ群：521797692

> github: [TPR-CMS](https://github.com/AxiosCros/tpr-cms)

## TPR核心代码

-  基于thinkphp5的修订版框架 tpr-framework

> 因为tpr-framework基于thinkphp5.0.9开发, 所以早期版本与thinkphp5官方版命名空间相同，所以不兼容不能共存。但是使用方法基本与thinkphp5相同

> tpr-framework2.0+ 修改了命名空间，可以与thinkphp5的framework composer扩展共存。

> [https://github.com/AxiosCros/tpr-framework](https://github.com/AxiosCros/tpr-framework)


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
- RongIM
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
composer install
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

## 开源协议
> 遵循Apache2开源协议发布，并提供免费使用
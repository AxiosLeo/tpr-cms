基于TPR的后台管理系统
===============

> 交流QQ群：521797692

## TPR核心代码
- TPR-composer组件地址
> 兼容thinkphp5框架，可与thinkphp5框架共存

  > github:  
  > [https://github.com/AxiosCros/tpr-composer/releases](https://github.com/AxiosCros/tpr-composer/releases)

  > oschina:  
  > [http://git.oschina.net/AxiosCro/tpr-composer](http://git.oschina.net/AxiosCro/tpr-composer)

-  基于thinkphp5的修订版框架
> 因为与thinkphp5官方版命名空间相同，所以不兼容不能共存。但是使用方法基本与thinkphp5相同

> [https://github.com/AxiosCros/tpr-framework](https://github.com/AxiosCros/tpr-framework)

### 1.0+版
> github分支： 1.0-beta
> [看云：《TPR1.0接口开发框架使用文档》](http://www.kancloud.cn/axios/tpr)

### 2.0版(开发中)
> github分支： master
> [看云：《TPR2.0接口开发文档》](http://www.kancloud.cn/axios/tpr2)

## tpr-cms后台管理系统所需环境
* php7.0+ 
* php-fpm 
* pcntl
* posix 
* mysql5.5+
* redis , phpredis
* mongodb

## 框架特点
* **高并发**。有子进程回收机制与并发数限制的多并发解决方案

* 基于thinkphp5开发，无缝衔接thinkphp5的功能，加快开发速度

* 便捷的接口参数验证，可以在一定程度上保证接口访问的标准性

* 通过使用前置和后置中间件，可以有非常好的扩展性

* 接口缓存，可以非常方便的加速接口请求速度

* 支持多语言翻译，可以很方便的在中英文等多语言环境中切换

* 有诸多方便接口开发的功能服务类，如MongoService,MailService,ApiDocService等等

* 具有签名验证和令牌验证等功能

## 安装
``` shell
#github
git clone https://github.com/AxiosCros/tpr-cms.git

#oschina
git clone https://git.oschina.net/AxiosCro/tpr-cms.git

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
 > http://domain/index.php
 
* 管理系统
 > http://domain/admin.php
 > admin
 > 123456

## 开源协议
> 遵循Apache2开源协议发布，并提供免费使用
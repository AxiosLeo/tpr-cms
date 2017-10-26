基于TPR的后台管理系统
===============

> 前端页面基于layui2.0开发，后端逻辑基于tpr-framework框架核心开发

> 交流QQ群：521797692

> github: [TPR-CMS](https://github.com/AxiosCros/tpr-cms)

## TPR核心代码

-  基于thinkphp5的修订版框架 tpr-framework
> 因为与thinkphp5官方版命名空间相同，所以不兼容不能共存。但是使用方法基本与thinkphp5相同

> [https://github.com/AxiosCros/tpr-framework](https://github.com/AxiosCros/tpr-framework)


## tpr-cms后台管理系统所需环境
* php7.0+ 
* php-fpm 
* pcntl
* posix 
* mysql5.5+
* redis , phpredis  缓存建议使用redis
* mongodb  日志驱动建议使用Mongo


## 框架特点
* **异步队列**。有子进程回收机制与并发数限制的异步队列解决方案

* 框架核心(**tpr-framework**)基于thinkphp5.0.9开发，无缝衔接thinkphp5的功能，加快开发速度

* 便捷的**接口参数验证**，可以在一定程度上保证接口访问的标准性

* 通过使用前置和后置**中间件**，可以有非常好的扩展性

* **接口缓存**，可以非常方便的加速接口请求速度

* 支持**多语言翻译**，可以很方便的在中英文等多语言环境中切换

* **多应用多入口**的架构模式，更易于多端接口的开发维护工作

* 集成**workman**，实现长连接通信

* 集成**geaqrman**，实现cgi模式到cli模式的转换

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
 > http://domain/api.php
 
* 管理系统
 > http://domain/index.php
 
 > admin
 
 > 123456
 
* 演示版
 
 > [http://cms.hanxv.cn](http://cms.hanxv.cn)
 
 > test
 
 > 123456
 
 ## workman
 > 需要tpr-framework > 1.1.6
 
 ``` shell
 cd server/bin
 
 #以debug（调试）方式启动
 
 php workman_server.php start
 
 #以daemon（守护进程）方式启动
 
 php workman_server.php start -d
 
 #停止
 php workman_server.php stop
 
 #重启
 php workman_server.php restart
 
 #平滑重启
 php workman_server.php reload
 
 #查看状态
 php workman_server.php status
 
 #查看连接状态（需要Workerman版本>=3.5.0）
 php workman_server.php connections
 ```
 
 ## gearman
  > 需要tpr-framework > 1.1.6
  
 ``` shell
 cd server/bin
 sh gearman_run.sh 1
 #数字1为创建一个gearman worker
 
 ```
 

## 开源协议
> 遵循Apache2开源协议发布，并提供免费使用
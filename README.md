基于 TPR 的后台管理系统
===============

> 前端页面基于 [layui2](https://www.layui.com/) 开发，服务端基于 [TPR](https://github.com/AxiosCros/tpr) 框架核心开发

> Github: [TPR-CMS](https://github.com/AxiosCros/tpr-cms)

## tpr-cms后台管理系统所需环境
* php7.1+

## 下载源码
* github

```shell
git clone https://github.com/AxiosCros/tpr-cms.git
git checkout -b dev/tpr3 origin/dev/tpr3
```

##
``` shell
composer install --vvv
```

## 快速使用

### 启动 web 服务
```shell
composer run
```

* 接口
 > http://localhost:8088/index.php
 
* 管理系统
 > http://localhost:8088/admin.php

### 命令行方式

```shell
./tpr

# or

php tpr
```

## 开源协议
> 遵循 [MIT](./LICENSE) 开源协议发布，并提供免费使用
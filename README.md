面向多应用后端开发的管理系统和接口开发框架
===============

> 前端页面基于 [layui2](https://www.layui.com/) 开发，服务端基于 [TPR](https://github.com/AxiosCros/tpr) 框架核心开发

> Github: [TPR-CMS](https://github.com/AxiosCros/tpr-cms)

## 所需环境
* php7.1+

## 下载源码
* github

```shell
git clone https://github.com/AxiosCros/tpr-cms.git
```

##
``` shell
composer install
```

## 快速使用

* 启动 web 服务
```shell
composer start
```

* 访问默认接口
 > http://localhost:8088/index.php
 
* 访问管理系统
 > http://localhost:8088/admin.php

### 命令行方式

```shell
./tpr

# or

php tpr

# console output

Command Tools for TPR application 1.0.0

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  help  Displays help for a command
  list  Lists commands
  make  generate code of command
  test  test command
```

## 开源协议
> 遵循 [MIT](./LICENSE) 开源协议发布，并提供免费使用

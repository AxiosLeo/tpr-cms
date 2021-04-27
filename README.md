# TPR-CMS

> 面向多应用开发场景，集成后端接口及内容管理系统的开发框架。

> 前端页面基于 [layui2](https://www.layui.com/) 开发，服务端基于 [TPR](https://github.com/AxiosCros/tpr) 框架核心开发

> TPR 开发文档: [wiki](https://github.com/AxiosCros/tpr/wiki)

> QQ 群: 521797692

## 所需环境

* php7.4+
* php8     (TPR 5.0.8+)

## 下载源码

* github

```shell
git clone https://github.com/AxiosCros/tpr-cms.git
```

## 安装依赖

``` shell
composer install
```

## 快速使用

* 启动 web 服务
```shell
composer start
```

* 访问接口
  > http://localhost:8088/api.php
 
* 访问管理系统
  > http://localhost:8088/index.php

### 命令行方式

```shell
./tpr

# or
php tpr
```

console output

```shell
Command Tools for TPR application 1.0.0

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  clear  Clear cache
  help   Display help for a command
  list   List commands
  make   Generate code of command
```

## 开源协议

> 遵循 [MIT](LICENSE) 开源协议发布，并提供免费使用

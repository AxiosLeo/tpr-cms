# TPR-CMS

> CMS application using TPR.

> Base on [layui2](https://www.layui.com/) and [TPR Framework](https://github.com/AxiosCros/tpr)

> TPR [document](https://github.com/AxiosCros/tpr/wiki)

## Required

- php8.1+

## Download

- github

```shell
git clone https://github.com/AxiosCros/tpr-cms.git
```

## Install dependencies

```shell
composer install
```

## Quick Start

```shell
composer run start
```

- api server

  > http://localhost:8088/api.php

- admin system
  > http://localhost:8088/index.php

### CLI application

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

## License

The TPR-CMS is open-sourced software licensed under the [MIT](LICENSE).

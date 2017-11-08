#!/usr/bin/env bash

server=$1
echo "server name:"$server

ps -ef |grep $server | grep -v grep|cut -c 9-15 |xargs kill -s 9

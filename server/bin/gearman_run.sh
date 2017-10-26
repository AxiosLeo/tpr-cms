#!/usr/bin/env bash
ps -ef |grep gearman_server | grep -v grep|cut -c 9-15 |xargs kill -s 9
for k in $( seq 1 $1)
do
  nohup php  gearman_server.php &
done
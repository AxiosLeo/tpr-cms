#!/usr/bin/env bash

server=$1
echo "server name:"$server

php  bin/$server.php stop

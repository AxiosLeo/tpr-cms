#!/usr/bin/env bash
server=$1
times=$2
echo "server name:"$server
echo "run times:"$times
date=$(date +%Y%m%d)
path=$(pwd)/
runtime_dir=$path../../runtime/server/$server/
runtime_path=$runtime_dir/$date.log
if [ ! -d "$runtime_dir" ]; then
 mkdir -p "$runtime_dir"
fi
if [ ! -f "$runtime_path" ]; then
 touch "$runtime_path"
fi
for k in $( seq 1 $times)
do
    nohup php  bin/$server.php start > ./server.log 2>&1 &
done

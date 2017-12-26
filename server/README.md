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
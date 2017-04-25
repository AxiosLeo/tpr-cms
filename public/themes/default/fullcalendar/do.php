<?php
include_once('connect.php');//连接数据库

$action = $_POST['action'];
if($action=='add'){
	$events = stripslashes(trim($_POST['event']));//事件内容
	$events=mysql_real_escape_string(strip_tags($events),$link); //过滤HTML标签，并转义特殊字符

	$isallday = $_POST['isallday'];//是否是全天事件
	$isend = $_POST['isend'];//是否有结束时间

	$startdate = trim($_POST['startdate']);//开始日期
	$enddate = trim($_POST['enddate']);//结束日期

	$s_time = $_POST['s_hour'].':'.$_POST['s_minute'].':00';//开始时间
	$e_time = $_POST['e_hour'].':'.$_POST['e_minute'].':00';//结束时间

	if($isallday==1 && $isend==1){
		$starttime = strtotime($startdate);
		$endtime = strtotime($enddate);
	}elseif($isallday==1 && $isend==""){
		$starttime = strtotime($startdate);
	}elseif($isallday=="" && $isend==1){
		$starttime = strtotime($startdate.' '.$s_time);
		$endtime = strtotime($enddate.' '.$e_time);
	}else{
		$starttime = strtotime($startdate.' '.$s_time);
	}

	$colors = array("#360","#f30","#06c");
	$key = array_rand($colors);
	$color = $colors[$key];

	$isallday = $isallday?1:0;
	$query = mysql_query("insert into `calendar` (`title`,`starttime`,`endtime`,`allday`,`color`) values ('$events','$starttime','$endtime','$isallday','$color')");
	if(mysql_insert_id()>0){
		echo '1';
	}else{
		echo '写入失败！';
	}
}
?>
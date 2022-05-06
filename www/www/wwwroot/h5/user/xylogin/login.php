<?php
error_reporting(0);
header('Content-type:text/json;charset=utf-8');
session_start();
include "config.php";

$loginName = $_GET['user'];
$loginPwd = $_GET['pass'];

$con=mysql_connect($PZ['DB_HOST'],$PZ['DB_USER'],$PZ['DB_PWD']);

if(!$con){
	echo '{"code":"LOGIN_FAILED","desc":"服务器链接异常","group":"user-provider","requestId":"access_open_api_guozi"}';die;
}



mysql_select_db($PZ['DB_NAME'],$con);


$dbusername=null;
$dbpassword=null;
$result=mysql_query("select * from user where loginName='".$loginName."';");

while($row=mysql_fetch_array($result)){
	$dbuserid=$row["id"];
	$dbusername=$row["loginName"];
	$dbpassword=$row["loginPwd"];
}



if(is_null($dbusername)){
	//直接注册
$uid = base_convert(uniqid(), 16, 10);
mysql_query("insert into user (id,loginName,loginPwd) values('$uid','$loginName','$loginPwd')"); 
      	$md5 = $loginName;
		echo $md5;
}
else{
	

	if($dbpassword!= $loginPwd){
		echo 'QQ';die;
	}else{
      	$md5 = $loginName;
		echo ''.$md5.'';
		
	}
}
mysql_close($con);
?>
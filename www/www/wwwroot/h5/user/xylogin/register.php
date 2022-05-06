<?php
error_reporting(0);
header('Content-type:text/json;charset=utf-8');
session_start();
include "config.php";

$loginName = $_GET['user']; 
$loginPwd = $_GET['pass'];


if($loginName=='' || $loginPwd ==''){
	echo '{"code":"ACCOUNT_ALREDAY_EXIST","desc":"提交参数异常","group":"user-provider","requestId":"access_open_api_guozi"}';die;
}
$con=mysql_connect($PZ['DB_HOST'],$PZ['DB_USER'],$PZ['DB_PWD']);
if(!$con){
	echo '{"code":"ACCOUNT_ALREDAY_EXIST","desc":"服务器连接异常","group":"user-provider","requestId":"access_open_api_guozi"}';die;
}
mysql_select_db($PZ['DB_NAME'],$con);
$result = mysql_query("select loginName from account");
while($row = mysql_fetch_array($result)){
	if($loginName == $row['loginName']) {    
		echo '{"code":"ACCOUNT_ALREDAY_EXIST","desc":"账户已经存在","group":"user-provider","requestId":"access_open_api_guozi"}';die;
	}
}
$uid = base_convert(uniqid(), 16, 10);
$success = mysql_query("insert into account (id,loginName,loginPwd) values('$uid','$loginName','$loginPwd')"); 
if($success) {
	$md5 = md5($loginName.$loginPwd.time()).'.'.time();
	$xpass = md5($loginPwd);
	echo '{"code":"SUCCESS","desc":"注册成功!"}';
}else {
	echo '{"code":"ACCOUNT_ALREDAY_EXIST","desc":"未知错误!","group":"user-provider","requestId":"access_open_api_guozi"}';
} 

mysql_close($con);
?>
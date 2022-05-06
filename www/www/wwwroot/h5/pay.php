<?php
include 'config.php';
header("Content-type: text/html; charset=utf8");
if($isrecharge==false){
	echo "内充关闭";
	exit;
}
$uid = isset($_REQUEST['uid']) ? $_REQUEST['uid']:'';
$serverid=isset($_REQUEST['serverid']) ? $_REQUEST['serverid']:'';
$rechargeid=isset($_REQUEST['rechargeid']) ? $_REQUEST['rechargeid']:'';
$order=isset($_REQUEST['order']) ? $_REQUEST['order']:'';
if(($uid || $serverid || $rechargeid)==''){
	echo "参数错误";
	exit;
}
$mysqli = mysqli_connect($dbip, $dbuser, $dbpwd, 'dslh1', "3306");
$mysqli->set_charset('utf8');
$query = $mysqli->prepare("select * from `players` where account=?");
$query->bind_param('s',$uid);
$query->execute();
$result = $query->get_result();
$num=mysqli_num_rows($result);
$row=mysqli_fetch_all($result);
mysqli_free_result($result);
if($result==null || $num<=0){
	echo "帐号不存在";
	exit;
}else{
	if($opendaili==true){
	$url=$payurl."?uid=".$uid."&serverid=".$serverid."&order=".$order;	
	}else{
	$money=$list[$rechargeid][1];
	$url=$payurl."?gameuser=".$uid."&paymoney=".$money;
	}
	
	header("location: $url");
	exit;
	
}
?>
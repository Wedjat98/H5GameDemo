<?php 
error_reporting(0);
$cdk='============================================'.
'版本 2019 Powered by 探花资源网 QQ:1084855250，禁止修改'.
'=================================================';
session_start();
$_SESSION['gmbt'] ='探花资源网';
//=========================================
$db_host='127.0.0.1';
$db_username='root';//数据库帐号
$db_password='123456';//数据库密码
$dbport = 3306;
$now = date('Y-m-d H:i:s',strtotime('now')); 
/*
 提示：gm文件夹必需给777权限
*/
//===============游戏分区=================================
$qu  = trim($_POST['qu']);
if($_POST['qu']==1){
	$dbgame='xntg1';//一区角色数据库
	$path='/H5/server/sh';    //修改.sh路径位置
}elseif($_POST['qu']==2){
	$dbgame='xntg2';//二区角色数据库
	$path='/H5/server/sh2';    //修改.sh路径位置
}
elseif($_POST['qu']==3){
	$dbgame='xntg3';//三区角色数据库
	$path='/H5/server/sh3';    //修改.sh路径位置
}
elseif($_POST['qu']==4){
	$dbgame='xntg4';//四区角色数据库
	$path='/H5/server/sh4';    //修改.sh路径位置
}			
//=========================================================
$admin='tanhua'; 	//首次登陆账号
$adminpass='tanhua';  //首次登陆密码	
$gmdb = "GMQq32368138";	//后台数据库名称
//=========================================================
	$charges=array(
		'1'=>'终身卡',
		'2'=>'月卡',
		'3'=>'100000元宝',
		'4'=>'200000元宝',
		'5'=>'300000元宝',
		'6'=>'500000元宝',
		'7'=>'1000000元宝',
		'8'=>'2000000元宝',
		'9'=>'3000000元宝',
		'10'=>'5000000元宝',
		'11'=>'10000000元宝',
		'12'=>'20000000元宝',
		'13'=>'30000000元宝',
		'14'=>'50000000元宝',
		'15'=>'开服第1天：人民币礼包10元',
		'16'=>'开服第2天：人民币礼包10元',
		'17'=>'开服第3天：人民币礼包10元',
		'18'=>'开服第4天：人民币礼包20元',
		'19'=>'开服第5天：人民币礼包20元',
		'20'=>'开服第6天：人民币礼包20元',
		'21'=>'开服第7天：人民币礼包50元',	
		'22'=>'开服第8天：人民币礼包50元',	
		'23'=>'首充10元',	
		'24'=>'首充50元',	
		'25'=>'首充100元',	
		'26'=>'首充500元',	
	);
//=========================================================	
	$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
	$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
?>
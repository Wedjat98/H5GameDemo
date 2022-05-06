<?php
/*By 探花 QQ1084855250
专业双端分发、IOS签名、各类游戏架设、游戏后台定做

WEB接收地址：http://域名/api/order/order_charge/index.php
下发字符串：ordernumber=订单号码&gameid=分区ID&userid=充值账号&realmoney=实际充值金额&paychannel=充值通道&gamecurrency=游戏币&sign=MD5(充值通道密钥订单号码充值账号实际充值金额游戏币)
*/
include 'config.php';
header("Content-type: text/html; charset=utf8");
$gameid = isset($_REQUEST['gameid']) ? $_REQUEST['gameid']:'';
$order = isset($_REQUEST['ordernumber']) ? $_REQUEST['ordernumber']:'';
$userid =isset($_REQUEST['userid']) ? $_REQUEST['userid']:'';
$paytype=isset($_GET['paychannel']) ? $_GET['paychannel'] :"未知渠道";
$realmoney = isset($_REQUEST['realmoney']) ? $_REQUEST['realmoney']:'0';
$gamecurrency = isset($_REQUEST['gamecurrency']) ? $_REQUEST['gamecurrency']:'0';
$sign = isset($_REQUEST['sign']) ? $_REQUEST['sign']:'';
$md5 = md5($paytype.$key.$order.$userid.$realmoney.$gamecurrency);
if(false == ($order || $userid || $realmoney || $gamecurrency || $sign)){
exit('参数错误');
}
if($md5 != $sign){
echo '验证失败';//验证失败
exit;
}
if($gamecurrency/$realmoney!=$bl){
echo '0';//比例异常
exit;
}
$con=mysql_connect($dbip,$dbuser,$dbpwd);
if(!$con) {  
        echo "数据库链接失败1";
exit;
    }
$db_select1 = mysql_select_db("dslh1",$con);
if(!$db_select1) {  
       echo "数据库链接失败";
   exit;
    }
mysql_query("set names 'utf8'"); 
$sql = "select * from `players` where `account`='$userid'";
$row = mysql_num_rows(mysql_query($sql));
if($row<1){
echo '查询不到帐号';
mysql_close($con);
exit;
}
$ordernum = time().rand(10000,99999);
foreach ($list as $key => $value) {
	if($realmoney==$value[1]){
		 $chargeid=$key;
		 break;
	 } 	
}
$sql = "insert into `pay` (dbid,playerid,serverid,goodsid) values ({$ordernum},(select dbid from `players` where `account` = '{$userid}'),1,{$chargeid})";
$result=mysql_query($sql);
if($result){
	echo "ok";
	exit;
}else{
	echo "ng";
	exit;
}
?>
 
 
<?php
/**
* 不要修改此版权，否则死全家！
* @date: 2018年5月22日 下午10:18:01
* @author: 欢乐逗(QQ:1242821087)
* 开启session
* 关闭报错提示
* 设置编码，防止出错
* 控制时区
* 数据库配置信息
* 数据库IP
* 数据库用户名
* 数据库密码
* 数据库名
* 充值标识，用于区分混服，和API必须统一，否则充值将中断
**/
session_start();
error_reporting(0);
header("Content-Type: text/html;charset=utf-8");
date_default_timezone_set('prc');

$db=array(
'db_server'  =>'127.0.0.1:3306',
'db_name'    =>'root',
'db_password'=>'123456',
'database'   =>'web',
'guanjianci' =>'百战沙城',
'miaoshu'    =>'百战沙城',
);
//连接数据库
$conn=@mysql_connect($db['db_server'],$db['db_name'],$db['db_password']) or die("数据库连接失败,请联系管理员！".$qq);
mysql_select_db($db['database'],$conn);
mysql_query("SET NAMES utf8");
//end
function getstr($str){
    if(isset($_GET[$str])){
        return $_GET[$str];
    }
    die("this link server do not exist");//Links do not exist
}
function poststr($str){
    if(isset($_POST[$str])){
        return $_POST[$str];
    }
    die("this link server do not exist");
}
function dbselect($db, $table, $type)
{
    $dbselect = mysql_query('SELECT * FROM '.$db.'.'.$table.' where '.$type);	
	$rowselect = mysql_fetch_array($dbselect);	
    return $rowselect;
}
//mysql total
function dbtotal($db, $table, $type)
{
    $dbtotal = mysql_query('SELECT * FROM '.$db.'.'.$table.' where '.$type);
    $rowtotal = mysql_num_rows($dbtotal);
    return $rowtotal;
}
?>
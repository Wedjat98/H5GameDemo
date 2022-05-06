<?php
/**
 * Created by PhpStorm.
 * User: koumoe
 * Date: 2018/4/10
 * Time: 下午1:12
 */
include_once ('../../config.php');
$request = $request1 =  $_POST;
$server = $request['server_id'];
//------------------验证开始----------------------------
$sign = $request['sign'];
unset($request['sign']);
$str = '';
while (list($arrkey, $val) = each($request)){
    $val = rawurlencode($val);
    $str .= $arrkey.'='.$val.'&';
}
$str = rtrim($str, '&');
$str = md5($str.$key);
//------------------验证结束--------------------
if($str != $sign){
    exit('error');
}
$sql = "select * from web.player where player_id = '".$request['player_id']."'";
$sql_result = $pdo->query($sql);
$player = $sql_result->fetchAll();
if($player){
    $sql = 'update web.player set ';
    unset($request1['sign']);
    while (list($arrkey, $val) = each($request1)){
        $sql1 .= "`$arrkey` = '".urldecode($val)."',";
    }
    $sql1 = rtrim($sql1, ',');
    $sql = $sql.$sql1." where player_id = '".$request1['player_id']."'";
    $pdo -> query($sql);
}else{
    $sql = 'insert into web.player(';
    $sql1 ='';
    $sql2 = '';
    unset($request1['sign']);
    while (list($arrkey, $val) = each($request1)){
        $sql1 .= "`$arrkey`,";
        $sql2 .= "'".urldecode($val)."',";
    }
    $sql1 = rtrim($sql1, ',');
    $sql2 = rtrim($sql2, ',');
    $sql = $sql.$sql1.") value (".$sql2.")";
    $pdo -> query($sql);
}
if($pdo){
    $result = array("code" => "1000", "data" => "success");
}else{
    $result = array("code" => "0", "data" => "fail");
}
echo base64_encode(json_encode($result));
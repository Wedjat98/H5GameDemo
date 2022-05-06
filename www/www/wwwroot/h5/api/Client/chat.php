<?php
/**
 * Created by PhpStorm.
 * User: koumoe
 * Date: 2018/4/10
 * Time: 下午1:12
 */
include_once ('../../config.php');
$content=$_POST['content'];
$nickname=$_POST['nickname'];
$url_nickname = urlencode($nickname);
$platform=$_POST['platform'];
$player_id=$_POST['player_id'];
$server_id=$_POST['server_id'];
$time=$_POST['time'];
$to_nickname=$_POST['to_nickname'];
$url_to_nickname = urlencode($to_nickname);
$to_player_id=$_POST['to_player_id'];
$type=$_POST['type'];
$username=$_POST['username'];
$sign = $_POST['sign'];
$str = "content=$content&nickname=$url_nickname&platform=$platform&player_id=$player_id&server_id=$server_id&time=$time&to_nickname=$to_nickname&to_player_id=$to_player_id&type=$type&username=$username".$key;
$str = md5($str);
if($str != $sign){
    exit("error");
}
$sql = "insert into web.log_chat(`player_id`,`username`,`nickname`,`type`,`content`,`platform`,`server_id`,`time`,`to_nickname`,`to_player_id`) value('".$player_id."','".$username."','".$nickname."','".$type."','".$content."','".$platform."','".$server_id."','".$time."','".$to_nickname."','".$to_player_id."')";
$pdo -> query($sql);
if($pdo){
    $result = array("code" => "1000", "data" => "success");
}else{
    $result = array("code" => "0", "data" => "fail");
}
echo base64_encode(json_encode($result));
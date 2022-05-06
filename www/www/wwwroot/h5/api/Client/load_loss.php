<?php
/**
 * Created by PhpStorm.
 * User: koumoe
 * Date: 2018/4/10
 * Time: 下午1:11
 */
include_once ('../../config.php');
$browser=$_POST['browser'];
$os=$_POST['os'];
$url_os = rawurlencode($os);
$platform=$_POST['platform'];
$server_id=$_POST['server_id'];
$type=$_POST['type'];
$username=$_POST['username'];
$via = $_POST['via'];
$sign = $_POST['sign'];
$str = "browser=$browser&os=$url_os&platform=$platform&server_id=$server_id&type=$type&username=$username&via=$via".$key;
$str = md5($str);
if($str != $sign){
    exit("error");
}
$sql = "insert into web.load_loss(`browser`,`os`,`platform`,`server_id`,`type`,`username`,`via`) value('".$browser."','".$os."','".$platform."','".$server_id."','".$type."','".$username."','".$via."')";
$pdo -> query($sql);
if($pdo){
    $result = array("code" => "1000", "data" => "success");
}else{
    $result = array("code" => "0", "data" => "fail");
}
echo base64_encode(json_encode($result));
<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/2/26
 * Time: 下午5:44
 */
error_reporting(0);
$pdo = new PDO("mysql:host=127.0.0.1;dbname=web","root","123456");
$pdo->exec('set names utf8');

date_default_timezone_set('PRC');
//通过分区判断数据库.要注意合区.

//define
$version = time();
$ver = "/bzsc/";
$url = "https://th.mdhzi.cn";
$key = "bzsch5_Qm!*l98&CKEY";

$fw_key = "MIR20180526";

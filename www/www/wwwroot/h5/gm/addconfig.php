<?php

error_reporting(0);
include 'config.php';
$username = $_POST['username'];
$password = $_POST['password'];
$gamename = $_POST['gamename'];
if ($_POST['endtime'] == '') {
	$date = date('Y-m-d H:i:s', strtotime('+9years'));
} elseif ($_POST['endtime'] == 1) {
	$date = date('Y-m-d H:i:s', strtotime('+1month'));
} elseif ($_POST['endtime'] == 2) {
	$date = date('Y-m-d H:i:s', strtotime('+2month'));
} elseif ($_POST['endtime'] == 3) {
	$date = date('Y-m-d H:i:s', strtotime('+3month'));
} elseif ($_POST['endtime'] == 6) {
	$date = date('Y-m-d H:i:s', strtotime('+6month'));
} elseif ($_POST['endtime'] == 12) {
	$date = date('Y-m-d H:i:s', strtotime('+1years'));
} elseif ($_POST['endtime'] == 99) {
	$date = date('Y-m-d H:i:s', strtotime('+9years'));
}
$vip = $_POST['vip'];
$mysqli = new mysqli($db_host, $db_username, $db_password, $dbgame, $dbport);
$mysqli->set_charset('utf8');
$query = $mysqli->prepare("SELECT * FROM `players` WHERE `account` LIKE ? or `name` LIKE ? limit 1");
$query->bind_param('ss', $gamename, $gamename);
$query->execute();
$result = $query->get_result();
$row = mysqli_fetch_array($result);
$roleid = $row['dbid'];
if (!empty($gamename) && empty($roleid)) {
	echo "<script>alert('数据库无此角色');history.go(-1)</script>";
	exit;
}
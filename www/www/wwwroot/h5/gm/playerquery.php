<?php

error_reporting(0);
header('Content-type: text/html; charset=utf-8');
ini_set('date.timezone', 'Asia/Shanghai');
include 'config.php';
$mysqli = new mysqli($db_host, $db_username, $db_password, $gmdb, $dbport);
if (!$mysqli) {
	echo "<script>alert('系统提示：数据库连接失败');history.go(-1)</script>";
	exit;
}
session_start();
$mysqli->set_charset('utf8');
$query = $mysqli->prepare("select * from `user` where `user`=? and `password`=? limit 1");
$query->bind_param('ss', $_SESSION["user"], $_SESSION["password"]);
$query->execute();
$result = $query->get_result();
$row = mysqli_fetch_array($result);
$check = md5($row['user'] . $row['password']);
$status = $row['status'];
if ($_SESSION['check'] != $check || empty($_SESSION['status']) || $_SESSION['status'] != $status and $_SESSION['status'] != 'vip1' || $_SESSION['status'] != 'vip2' || $_SESSION['status'] != 'vip3' || $_SESSION['status'] != 'vip4' || $_SESSION['status'] != 'vip5') {
	unset($_SESSION);
	echo '<script>alert(\'您无此权限！\');window.location.href=\'index.php\';</script>';
	exit;
}
if (isset($_SESSION['expiretime'])) {
	if ($_SESSION['expiretime'] < time()) {
		unset($_SESSION['expiretime']);
		header('Location: exit.php?TIMEOUT');
		exit(0);
	} else {
		$_SESSION['expiretime'] = time() + 3600;
	}
}
$name = $_SESSION["name"];
$mysql1 = new mysqli($db_host, $db_username, $db_password, $dbgame, $dbport);
$mysql1->set_charset('utf8');
$query1 = $mysql1->prepare("SELECT * FROM players WHERE account LIKE ? or name LIKE ? limit 1");
$query1->bind_param('ss', $name, $name);
$query1->execute();
$result1 = $query1->get_result();
$row1 = mysqli_fetch_array($result1);
$roleid = $row1['dbid'];
$serverid = $row1['serverid'];
if ($roleid != $row['roleid'] || $_SESSION['qu'] != $row['qu']) {
	echo "<script>alert('玩家账号异常!');history.go(-1)</script>";
	exit;
}
if ($_POST) {
	switch ($_POST['sub']) {
		case 'cz':
			if (empty($roleid)) {
				echo "<script>alert('数据库无此角色');history.go(-1)</script>";
				exit;
			}
			$oid = time();
			$goodsid = $_POST['goodsid'];
			$log = 'log/player_charge_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if (!empty($goodsid)) {
				$mysql1->set_charset('utf8');
				$query1 = $mysql1->prepare("insert into `pay` (`dbid`,`playerid`,`serverid`,`goodsid`) values (?,?,?,?)");
				$query1->bind_param('ssss', $oid, $roleid, $serverid, $goodsid);
				$query1->execute();
				file_put_contents($log, $date . "\t" . $serverid . "\t" . $name . "\t" . $roleid . "\t" . $goodsid . "\t" . "success\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'充值成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $serverid . "\t" . $name . "\t" . $roleid . "\t" . $goodsid . "\t" . "failed\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'充值失败\');history.go(-1)</script>';
			}
			break;
		case 'mail':
			if (empty($roleid)) {
				echo "<script>alert('数据库无此角色');history.go(-1)</script>";
				exit;
			}
			$itemtype = $_POST['itemtype'];
			$num = $_POST['num'];
			$itemstr = $itemtype .= '_';
			if ($itemtype == 0) {
				$itemstr .= $_POST['huobiid'] .= '_';
			} elseif ($itemtype == 1) {
				if ($num < 1 || $num > 999999) {
					echo "<script>alert('数量范围：1-999999');history.go(-1)</script>";
					exit;
				}
				$item = trim($_POST['item']);
				$itemfile = 'stop/item.' . $qu . '.json';
				$fp = fopen($itemfile, "a+");
				if (filesize($itemfile) > 0) {
					$str = fread($fp, filesize($itemfile));
					fclose($fp);
					$itemjson = json_decode($str);
					if ($itemjson == null) {
						$itemjson = array();
					}
				} else {
					$itemjson = array();
				}
				if (in_array($item, $itemjson)) {
					$return = array('errcode' => 1);
					echo '<script>alert(\'禁止发送GM禁用物品\');history.go(-1)</script>';
					exit(json_encode($return));
				}
				$itemstr .= $_POST['item'] .= '_';
			}
			$itemstr .= $num;
			$items = explode('_', $itemstr);
			$log = 'log/player_mail_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($items != '') {
				$mysql1->set_charset('utf8');
				$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2, param3, param4) values (?,'mail',?,?,?,?)");
				$query1->bind_param('sssss', $serverid, $roleid, $items[0], $items[1], $items[2]);
				$query1->execute();
				file_put_contents($log, $date . "\t" . $qu . "\t" . $name . "\t" . $roleid . "\t" . $_POST['item'] . "\t" . $num . "\t" . "success\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'邮件发送成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $_POST['item'] . "\t" . $num . "\t" . "failed\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'邮件发送失败：\');history.go(-1)</script>';
			}
			break;
		default:
			echo '<script>alert(\'未知操作\');history.go(-1)</script>';
			exit;
			break;
	}
}
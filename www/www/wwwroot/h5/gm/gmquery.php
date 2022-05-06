<?php

header('Content-type: text/html; charset=utf-8');
ini_set('date.timezone', 'Asia/Shanghai');
include 'config.php';
$mysqli = new mysqli($db_host, $db_username, $db_password, $gmdb, $dbport);
if (!$mysqli) {
	echo "<script>alert('系统提示：数据库连接失败');history.go(-1)</script>";
	exit;
}
$mysqli->set_charset('utf8');
$query = $mysqli->prepare("select * from `user` where `user`=? and `password`=? limit 1");
$query->bind_param('ss', $_SESSION["user"], $_SESSION["password"]);
$query->execute();
$result = $query->get_result();
$row = mysqli_fetch_array($result);
$check = md5($row['user'] . $row['password']);
if ($_SESSION['check'] != $check || empty($_SESSION['status']) || $_SESSION['status'] != $row['status'] and $_SESSION['status'] != 'admin' || $_SESSION['status'] != 'proxy') {
	unset($_SESSION);
	echo '<script>alert(\'您无此权限！\');window.location.href=\'index.php\';</script>';
	exit;
}
if (isset($_SESSION['expiretime'])) {
	if ($_SESSION['expiretime'] < time()) {
		unset($_SESSION['expiretime']);
		$query = $mysqli->prepare("INSERT INTO gmlog (user, create_time,name,remark,ip) VALUES (?, now(),?,'退出登陆',?)");
		$query->bind_param('sss', $_SESSION["user"], $_SESSION["name"], $user_IP);
		$query->execute();
		$mysqli->close();
		header('Location: exit.php?TIMEOUT');
		exit(0);
	} else {
		$_SESSION['expiretime'] = time() + 3600;
	}
}
$name = $_POST['username'];
$mysql1 = new mysqli($db_host, $db_username, $db_password, $dbgame, $dbport);
$mysql1->set_charset('utf8');
$query1 = $mysql1->prepare("SELECT * FROM players WHERE account LIKE ? or name LIKE ? limit 1");
$query1->bind_param('ss', $name, $name);
$query1->execute();
$result1 = $query1->get_result();
$row1 = mysqli_fetch_array($result1);
$roleid = $row1['dbid'];
$serverid = $row1['serverid'];
if ($_POST) {
	switch ($_POST['sub']) {
		case 'cz':
			if (empty($roleid)) {
				echo "<script>alert('数据库无此角色');history.go(-1)</script>";
				exit;
			}
			$oid = time();
			$goodsid = $_POST['goodsid'];
			$log = 'log/charge_' . date('Y-m-d') . '.log';
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
				$itemstr .= $_POST['item'] .= '_';
			}
			$itemstr .= $num;
			$items = explode('_', $itemstr);
			$log = 'log/mail_' . date('Y-m-d') . '.log';
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
		case 'allmail':
			$itemtype = $_POST['itemtype'];
			$num = $_POST['num'];
			$level = $_POST['level'];
			$itemstr = $itemtype .= '_';
			if ($itemtype == 0) {
				$itemstr .= $_POST['huobiid'] .= '_';
			} elseif ($itemtype == 1) {
				if ($num < 1 || $num > 999999) {
					echo "<script>alert('数量范围：1-999999');history.go(-1)</script>";
					exit;
				}
				$itemstr .= $_POST['item'] .= '_';
			}
			$itemstr .= $num;
			$items = explode('_', $itemstr);
			$log = 'log/allmail_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($items != '') {
				$mysql1->set_charset('utf8');
				$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2, param3, param4) select serverid,'mail',dbid ,?,?,? from players where level >?");
				$query1->bind_param('ssss', $items[0], $items[1], $items[2], $level);
				$query1->execute();
				file_put_contents($log, $date . "\t" . $qu . "\t等级大于" . $level . "\t" . $_POST['item'] . "\t" . $num . "\t" . "全服邮件发送成功\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'全服邮件发送成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t等级大于" . $level . "\t" . $_POST['item'] . "\t" . $num . "\t" . "全服邮件发送失败\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'全服邮件发送失败：\');history.go(-1)</script>';
			}
			break;
		case 'yz1':
			$log = 'log/yz_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$file = fopen("onekey/yz1.txt", "r");
				while (!feof($file)) {
					$line = fgets($file);
					$yzitem = explode(';', $line);
					if (count($yzitem) == 3) {
						$mysql1->set_charset('utf8');
						$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2, param3, param4) values (?,'mail','1',?,?,?)");
						$query1->bind_param('ssss', $serverid, $roleid, $yzitem[0], $yzitem[1]);
						$query1->execute();
						usleep(30000);
						file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $yzitem[0] . "\t" . $yzitem[1] . "\t" . " yz1 success\t" . $user_IP . PHP_EOL, FILE_APPEND);
					}
				}
				for ($i = 0; $i < count($yzitem); $i++) {
				}
				fclose($file);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $_POST['item'] . "\t" . $yzitem[1] . "\t" . "failed\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送失败：\');history.go(-1)</script>';
			}
			break;
		case 'yz2':
			$log = 'log/yz_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$file = fopen("onekey/yz2.txt", "r");
				while (!feof($file)) {
					$line = fgets($file);
					$yzitem = explode(';', $line);
					if (count($yzitem) == 3) {
						$mysql1->set_charset('utf8');
						$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2, param3, param4) values (?,'mail','1',?,?,?)");
						$query1->bind_param('ssss', $serverid, $roleid, $yzitem[0], $yzitem[1]);
						$query1->execute();
						usleep(30000);
						file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $yzitem[0] . "\t" . $yzitem[1] . "\t" . " yz2 success\t" . $user_IP . PHP_EOL, FILE_APPEND);
					}
				}
				for ($i = 0; $i < count($yzitem); $i++) {
				}
				fclose($file);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $_POST['item'] . "\t" . $yzitem[1] . "\t" . "failed\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送失败：\');history.go(-1)</script>';
			}
			break;
		case 'yz3':
			$log = 'log/yz_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$file = fopen("onekey/yz3.txt", "r");
				while (!feof($file)) {
					$line = fgets($file);
					$yzitem = explode(';', $line);
					if (count($yzitem) == 3) {
						$mysql1->set_charset('utf8');
						$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2, param3, param4) values (?,'mail','1',?,?,?)");
						$query1->bind_param('ssss', $serverid, $roleid, $yzitem[0], $yzitem[1]);
						$query1->execute();
						usleep(30000);
						file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $yzitem[0] . "\t" . $yzitem[1] . "\t" . " yz3 success\t" . $user_IP . PHP_EOL, FILE_APPEND);
					}
				}
				for ($i = 0; $i < count($yzitem); $i++) {
				}
				fclose($file);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $_POST['item'] . "\t" . $yzitem[1] . "\t" . "failed\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送失败：\');history.go(-1)</script>';
			}
			break;
		case 'yz4':
			$log = 'log/yz_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$file = fopen("onekey/yz4.txt", "r");
				while (!feof($file)) {
					$line = fgets($file);
					$yzitem = explode(';', $line);
					if (count($yzitem) == 3) {
						$mysql1->set_charset('utf8');
						$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2, param3, param4) values (?,'mail','1',?,?,?)");
						$query1->bind_param('ssss', $serverid, $roleid, $yzitem[0], $yzitem[1]);
						$query1->execute();
						usleep(30000);
						file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $yzitem[0] . "\t" . $yzitem[1] . "\t" . " yz4 success\t" . $user_IP . PHP_EOL, FILE_APPEND);
					}
				}
				for ($i = 0; $i < count($yzitem); $i++) {
				}
				fclose($file);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $_POST['item'] . "\t" . $yzitem[1] . "\t" . "failed\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送失败：\');history.go(-1)</script>';
			}
			break;
		case 'yz5':
			$log = 'log/yz_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$file = fopen("onekey/yz5.txt", "r");
				while (!feof($file)) {
					$line = fgets($file);
					$yzitem = explode(';', $line);
					if (count($yzitem) == 3) {
						$mysql1->set_charset('utf8');
						$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2, param3, param4) values (?,'mail','1',?,?,?)");
						$query1->bind_param('ssss', $serverid, $roleid, $yzitem[0], $yzitem[1]);
						$query1->execute();
						usleep(30000);
						file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $yzitem[0] . "\t" . $yzitem[1] . "\t" . " yz5 success\t" . $user_IP . PHP_EOL, FILE_APPEND);
					}
				}
				for ($i = 0; $i < count($yzitem); $i++) {
				}
				fclose($file);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $_POST['item'] . "\t" . $yzitem[1] . "\t" . "failed\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送失败：\');history.go(-1)</script>';
			}
			break;
		case 'yz6':
			$log = 'log/yz_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$file = fopen("onekey/yz6.txt", "r");
				while (!feof($file)) {
					$line = fgets($file);
					$yzitem = explode(';', $line);
					if (count($yzitem) == 3) {
						$mysql1->set_charset('utf8');
						$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2, param3, param4) values (?,'mail','1',?,?,?)");
						$query1->bind_param('ssss', $serverid, $roleid, $yzitem[0], $yzitem[1]);
						$query1->execute();
						usleep(30000);
						file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $yzitem[0] . "\t" . $yzitem[1] . "\t" . " yz6 success\t" . $user_IP . PHP_EOL, FILE_APPEND);
					}
				}
				for ($i = 0; $i < count($yzitem); $i++) {
				}
				fclose($file);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $_POST['item'] . "\t" . $yzitem[1] . "\t" . "failed\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送失败：\');history.go(-1)</script>';
			}
			break;
		case 'yz7':
			$log = 'log/yz_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$file = fopen("onekey/yz7.txt", "r");
				while (!feof($file)) {
					$line = fgets($file);
					$yzitem = explode(';', $line);
					if (count($yzitem) == 3) {
						$mysql1->set_charset('utf8');
						$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2, param3, param4) values (?,'mail','1',?,?,?)");
						$query1->bind_param('ssss', $serverid, $roleid, $yzitem[0], $yzitem[1]);
						$query1->execute();
						usleep(30000);
						file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $yzitem[0] . "\t" . $yzitem[1] . "\t" . " yz7 success\t" . $user_IP . PHP_EOL, FILE_APPEND);
					}
				}
				for ($i = 0; $i < count($yzitem); $i++) {
				}
				fclose($file);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $_POST['item'] . "\t" . $yzitem[1] . "\t" . "failed\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送失败：\');history.go(-1)</script>';
			}
			break;
		case 'yz8':
			$log = 'log/yz_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$file = fopen("onekey/yz8.txt", "r");
				while (!feof($file)) {
					$line = fgets($file);
					$yzitem = explode(';', $line);
					if (count($yzitem) == 3) {
						$mysql1->set_charset('utf8');
						$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2, param3, param4) values (?,'mail','1',?,?,?)");
						$query1->bind_param('ssss', $serverid, $roleid, $yzitem[0], $yzitem[1]);
						$query1->execute();
						usleep(30000);
						file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $yzitem[0] . "\t" . $yzitem[1] . "\t" . " yz8 success\t" . $user_IP . PHP_EOL, FILE_APPEND);
					}
				}
				for ($i = 0; $i < count($yzitem); $i++) {
				}
				fclose($file);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $_POST['item'] . "\t" . $yzitem[1] . "\t" . "failed\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送失败：\');history.go(-1)</script>';
			}
			break;
		case 'yz9':
			$log = 'log/yz_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$file = fopen("onekey/yz9.txt", "r");
				while (!feof($file)) {
					$line = fgets($file);
					$yzitem = explode(';', $line);
					if (count($yzitem) == 3) {
						$mysql1->set_charset('utf8');
						$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2, param3, param4) values (?,'mail','1',?,?,?)");
						$query1->bind_param('ssss', $serverid, $roleid, $yzitem[0], $yzitem[1]);
						$query1->execute();
						usleep(30000);
						file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $yzitem[0] . "\t" . $yzitem[1] . "\t" . " yz9 success\t" . $user_IP . PHP_EOL, FILE_APPEND);
					}
				}
				for ($i = 0; $i < count($yzitem); $i++) {
				}
				fclose($file);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $_POST['item'] . "\t" . $yzitem[1] . "\t" . "failed\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送失败：\');history.go(-1)</script>';
			}
			break;
		case 'yz10':
			$log = 'log/yz_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$file = fopen("onekey/yz10.txt", "r");
				while (!feof($file)) {
					$line = fgets($file);
					$yzitem = explode(';', $line);
					if (count($yzitem) == 3) {
						$mysql1->set_charset('utf8');
						$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2, param3, param4) values (?,'mail','1',?,?,?)");
						$query1->bind_param('ssss', $serverid, $roleid, $yzitem[0], $yzitem[1]);
						$query1->execute();
						usleep(30000);
						file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $yzitem[0] . "\t" . $yzitem[1] . "\t" . " yz10 success\t" . $user_IP . PHP_EOL, FILE_APPEND);
					}
				}
				for ($i = 0; $i < count($yzitem); $i++) {
				}
				fclose($file);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . $_POST['item'] . "\t" . $yzitem[1] . "\t" . "failed\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'一键邮件发送失败：\');history.go(-1)</script>';
			}
			break;
		case 'zhfh':
			$time = '1608568913';
			$log = 'log/other_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$mysql1->set_charset('utf8');
				$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2) values (?,'Sealed',?,?)");
				$query1->bind_param('sss', $serverid, $roleid, $time);
				$query1->execute();
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . "封禁成功！\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'封禁成功！\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . $time . "\t" . "封禁失败！\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'封禁失败！\');history.go(-1)</script>';
			}
			break;
		case 'zhjf':
			$time = '0';
			$log = 'log/other_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$mysql1->set_charset('utf8');
				$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2) values (?,'Sealed',?,?)");
				$query1->bind_param('sss', $serverid, $roleid, $time);
				$query1->execute();
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . "解封成功！\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'解封成功！\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . $time . "\t" . "解封失败！\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'解封失败！\');history.go(-1)</script>';
			}
			break;
		case 'jy':
			$time = '1608568913';
			$log = 'log/other_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$mysql1->set_charset('utf8');
				$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2) values (?,'Silent',?,?)");
				$query1->bind_param('sss', $serverid, $roleid, $time);
				$query1->execute();
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . "禁言成功！\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'禁言成功！\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . $time . "\t" . "禁言失败！\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'禁言失败！\');history.go(-1)</script>';
			}
			break;
		case 'jj':
			$time = '0';
			$log = 'log/other_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if ($roleid != '') {
				$mysql1->set_charset('utf8');
				$query1 = $mysql1->prepare("INSERT INTO gmcmd (serverid, cmd, param1, param2) values (?,'Silent',?,?)");
				$query1->bind_param('sss', $serverid, $roleid, $time);
				$query1->execute();
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . "\t" . "解禁成功！\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'解禁成功！\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $roleid . $time . "\t" . "解禁失败！\t" . $user_IP . PHP_EOL, FILE_APPEND);
				$mysql1->close();
				echo '<script>alert(\'解禁失败！\');history.go(-1)</script>';
			}
			break;
		case 'stop':
			$item = trim($_POST['item']);
			$log = 'log/stop_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
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
			if (!in_array($item, $itemjson)) {
				array_push($itemjson, $item);
				file_put_contents($itemfile, json_encode($itemjson));
				file_put_contents($log, $date . "\t" . $qu . "\t" . $item . "\t" . "禁发物品添加成功\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'添加GM禁止物品成功!!\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $qu . "\t" . $item . "\t" . "禁发物品添加失败\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'此物品ID已经添加了!!\');history.go(-1)</script>';
				exit;
			}
			break;
		case 'additem':
			$item = trim($_POST['item']);
			$status = trim($_POST['status']);
			$itemname = trim($_POST['itemname']);
			$log = 'log/item_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			$additem = 'onekey/' . $status . '.txt';
			$file = fopen($additem, "r");
			while (!feof($file)) {
				$line = fgets($file);
				$add1item = explode(';', $line);
				if ($add1item[0] == $item) {
					echo "<script>alert('您已经添加此物品ID了');history.go(-1)</script>";
					fclose($file);
					exit;
				}
				break;
			}
			if (!empty($status)) {
				file_put_contents($additem, $item . ";" . $itemname . PHP_EOL, FILE_APPEND);
				file_put_contents($log, $date . "\t" . $status . "\t" . $item . "\t" . $itemname . "\t" . "添加物品成功\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'添加物品成功!!\');history.go(-1)</script>';
				fclose($additem);
			} else {
				echo '<script>alert(\'此物品ID添加失败!!\');history.go(-1)</script>';
				file_put_contents($log, $date . "\t" . $status . "\t" . $item . "\t" . $itemname . "\t" . "添加物品失败\t" . $user_IP . PHP_EOL, FILE_APPEND);
				fclose($additem);
				exit;
			}
			break;
		case 'delitem':
			$status = trim($_POST['status']);
			$item = trim($_POST['delitem']);
			$log = 'log/item_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if (empty($status)) {
				echo "<script>alert('请选择要删除的物品表');history.go(-1)</script>";
				exit;
			}
			$itemfile = 'onekey/' . $status . '.txt';
			$n = 0;
			$file = fopen($itemfile, "r");
			while (!feof($file)) {
				$line = fgets($file);
				$delitem = explode(';', $line);
				if ($delitem[0] == $item) {
					fclose($file);
					break;
				}
				$n = $n + 1;
			}
			$n = $n + 1;
			$l = count(file($itemfile));
			if ($n <= $l) {
				$f1 = fopen($itemfile, 'r');
				$tmp = tempnam("/tmp", '');
				$f2 = fopen($tmp, 'w');
				$i = 0;
				while (!feof($f1)) {
					$line1 = fgets($f1);
					$i++;
					if ($i == $n) {
						continue;
					}
					fputs($f2, $line1);
				}
				fclose($f1);
				fclose($f2);
				rename($tmp, $itemfile);
				file_put_contents($log, $date . "\t" . $status . "\t" . $item . "\t" . "删除成功\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'删除成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $status . "\t" . $item . "\t" . "删除失败\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'删除失败\');history.go(-1)</script>';
			}
			break;
		case 'show':
			$status = trim($_POST['status']);
			$showitem = 'onekey/' . $status . '.txt';
			print_r('<pre>');
			print_r(file_get_contents($showitem, '<br/>'));
			break;
		case 'yzadditem':
			$item = trim($_POST['item']);
			$status = trim($_POST['status']);
			$num = trim($_POST['num']);
			$itemname = trim($_POST['itemname']);
			$log = 'log/item_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			$additem = 'onekey/' . $status . '.txt';
			$file = fopen($additem, "r");
			while (!feof($file)) {
				$line = fgets($file);
				$add1item = explode(';', $line);
				if ($add1item[0] == $item) {
					echo "<script>alert('您已经添加此物品ID了');history.go(-1)</script>";
					fclose($file);
					exit;
				}
				break;
			}
			if (!empty($status)) {
				file_put_contents($additem, $item . ";" . $num . ";" . $itemname . PHP_EOL, FILE_APPEND);
				file_put_contents($log, $date . "\t" . $status . "\t" . $item . "\t" . $num . "\t" . $itemname . "添加一键礼包物品成功\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'添加物品成功!!\');history.go(-1)</script>';
				fclose($additem);
			} else {
				file_put_contents($log, $date . "\t" . $status . "\t" . $item . "\t" . $num . "\t" . $itemname . "添加一键礼包物品失败\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'此物品ID添加失败!!\');history.go(-1)</script>';
				fclose($additem);
				exit;
			}
			break;
		case 'yzdelitem':
			$status = trim($_POST['status']);
			$item = trim($_POST['delitem']);
			$log = 'log/item_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			if (empty($status)) {
				echo "<script>alert('请选择要删除的物品表');history.go(-1)</script>";
				exit;
			}
			$itemfile = 'onekey/' . $status . '.txt';
			$n = 0;
			$file = fopen($itemfile, "r");
			while (!feof($file)) {
				$line = fgets($file);
				$delitem = explode(';', $line);
				if ($delitem[0] == $item) {
					fclose($file);
					break;
				}
				$n = $n + 1;
			}
			$n = $n + 1;
			$l = count(file($itemfile));
			if ($n <= $l) {
				$f1 = fopen($itemfile, 'r');
				$tmp = tempnam("/tmp", '');
				$f2 = fopen($tmp, 'w');
				$i = 0;
				while (!feof($f1)) {
					$line1 = fgets($f1);
					$i++;
					if ($i == $n) {
						continue;
					}
					fputs($f2, $line1);
				}
				fclose($f1);
				fclose($f2);
				rename($tmp, $itemfile);
				file_put_contents($log, $date . "\t" . $status . "\t" . $item . "\t" . "删除礼包物品成功\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'删除成功\');history.go(-1)</script>';
			} else {
				file_put_contents($log, $date . "\t" . $status . "\t" . $item . "\t" . "删除礼包物品失败\t" . $user_IP . PHP_EOL, FILE_APPEND);
				echo '<script>alert(\'删除失败\');history.go(-1)</script>';
			}
			break;
		case 'yzshow':
			$status = trim($_POST['status']);
			$showitem = 'onekey/' . $status . '.txt';
			print_r('<pre>');
			print_r(file_get_contents($showitem, '<br/>'));
			break;
		case 'start':
			$shell = $_POST['shell'];
			$log = 'log/system_' . date('Y-m-d') . '.log';
			$date = date('Y-m-d H:i:s');
			$locale = 'en_US.UTF-8';
			setlocale(LC_ALL, $locale);
			putenv('LC_ALL=' . $locale);
			$output = exec('cd ' . $path . ' && ./gamectl.sh ' . $shell);
			file_put_contents($log, $date . "\t" . $qu . "\t" . $shell . "\t" . "服务器命令启动成功\t" . $user_IP . PHP_EOL, FILE_APPEND);
			echo '<script>alert(\'服务器命令启动成功!\');history.go(-1)</script>';
			break;
		default:
			echo '<script>alert(\'未知操作\');history.go(-1)</script>';
			break;
			exit;
	}
}
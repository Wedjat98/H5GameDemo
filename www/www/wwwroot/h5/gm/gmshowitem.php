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
if ($_POST) {
	switch ($_POST['sub']) {
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
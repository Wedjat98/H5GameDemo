<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GM后台管理系统</title>
</head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<?php
include base64_decode('Y29uZmlnLnBocA==');$mysqli =new mysqli($db_host,$db_username,$db_password,$gmdb,$dbport);if(!$mysqli){echo "<script>alert('系统提示：数据库连接失败');history.go(-1)</script>";exit;}session_start();$mysqli->set_charset('utf8');$query =$mysqli->prepare("select * from `user` where `user`=? and `password`=? limit 1");$query->bind_param('ss', $_SESSION["user"], $_SESSION["password"]);$query->execute();$result =$query->get_result();$row =mysqli_fetch_array($result);$check =md5($row['user'] . $row['password']);$status=$row['status'];if ($_SESSION['check'] <> $check || empty($_SESSION['status'])|| $_SESSION['status'] <> $status || $_SESSION['status'] <> 'admin'){unset($_SESSION);echo base64_decode('PHNjcmlwdD5hbGVydCgn5oKo5peg5q2k5p2D6ZmQ77yBJyk7d2luZG93LmxvY2F0aW9uLmhyZWY9J2luZGV4LnBocCc7PC9zY3JpcHQ+');exit;}if(isset($_SESSION['expiretime'])){if($_SESSION['expiretime'] < time()){unset($_SESSION['expiretime']);$query =$mysqli->prepare("INSERT INTO gmlog (user, create_time,name,remark,ip) VALUES (?, now(),?,'退出登陆',?)");$query->bind_param('sss', $_SESSION["user"], $_SESSION["name"], $user_IP);$query->execute();$mysqli->close();header(base64_decode('TG9jYXRpb246IGV4aXQucGhwP1RJTUVPVVQ='));exit(0);}else {$_SESSION['expiretime'] =time()+ 3600;}}?>
<div class="text-center col-md-4 center-block">
<h1><?php echo $_SESSION['gmbt'];?>授权后台</h1>
 <h3 style="color:blue"><?php echo $_SESSION['name'];?> 欢迎登陆</h3> <br>
	<button class="btn btn-info btn-block" onclick="window.location.href='admin.php'">添加授权</button>
	<button class="btn btn-info btn-block" onclick="window.location.href='gmlist.php?page=1'">账号列表</button>
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmcz.php'">充值系统</button>
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmmail.php'">邮件系统</button>
	  <button class="btn btn-info btn-block" onclick="window.location.href='gmallmail.php'">全服邮件</button>
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmyz.php'">一键系统</button>
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmother.php'">其他功能</button>
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmsystem.php'">服务器功能</button>
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmstop.php'">添加禁发物品</button>	
	<button class="btn btn-info btn-block" onclick="window.location.href='gmitem.php'">增删后台物品</button>
	<button class="btn btn-info btn-block" onclick="window.location.href='exit.php'">登陆注销</button>	<br>	
 <p class="admin_copyright"> &copy; 2019 Powered by 探花资源网</p> 
 </div>
</div>
</body>
</html>
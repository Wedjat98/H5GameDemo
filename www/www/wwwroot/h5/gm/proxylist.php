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
	<script src="js/bootstrap.min.js"></script>
</head>
<body>
<?php
include base64_decode('Y29uZmlnLnBocA==');$mysqli =new mysqli($db_host,$db_username,$db_password,$gmdb,$dbport);if(!$mysqli){echo "<script>alert('系统提示：数据库连接失败');history.go(-1)</script>";exit;}session_start();$mysqli->set_charset('utf8');$query =$mysqli->prepare("select * from `user` where `user`=? and `password`=? limit 1");$query->bind_param('ss', $_SESSION["user"], $_SESSION["password"]);$query->execute();$result =$query->get_result();$row =mysqli_fetch_array($result);$check =md5($row['user'] . $row['password']);$status=$row['status'];if ($_SESSION['check'] <> $check || empty($_SESSION['status'])|| $_SESSION['status'] <> $status || $_SESSION['status'] <> 'proxy'){unset($_SESSION);echo base64_decode('PHNjcmlwdD5hbGVydCgn5oKo5peg5q2k5p2D6ZmQ77yBJyk7d2luZG93LmxvY2F0aW9uLmhyZWY9J2luZGV4LnBocCc7PC9zY3JpcHQ+');exit;}if(isset($_SESSION['expiretime'])){if($_SESSION['expiretime'] < time()){unset($_SESSION['expiretime']);header(base64_decode('TG9jYXRpb246IGV4aXQucGhwP1RJTUVPVVQ='));exit(0);}else {$_SESSION['expiretime'] =time()+ 3600;}}?>
<div class="text-center col-md-4 center-block">
<h1><?php echo $_SESSION['gmbt'];?>授权后台</h1>
 <h3 style="color:blue"><?php echo $_SESSION['name'];?> 欢迎登陆</h3> <br>
	<button class="btn btn-info btn-block" onclick="window.location.href='proxylist.php?page=1'">账号列表</button>
	<button class="btn btn-info btn-block" onclick="window.location.href='proxy.php'">返回主菜单</button>
	<button class="btn btn-info btn-block" onclick="window.location.href='exit.php'">登陆注销</button>	
	 <table style='text-align:margin：auto;' class="table table-bordered" border='1'width="40%"> <tr><th style='text-align: center;'>用户名</th><th style='text-align: center;'>游戏账号或角色名</th><th style='text-align: center;'>权限</th><th style='text-align: center;'>分区</th></th><th style='text-align: center;'>绑定角色ID</th><th style='text-align: center;'>有效时间</th></th><th style='text-align: center;'>改/删</th></tr> 
	<?php
 require base64_decode('Y29uZmlnLnBocA==');$con =@mysql_connect($db_host,$db_username,$db_password)or die(mysql_error());mysql_query(base64_decode('c2V0IG5hbWVzIFVURjg='));mysql_select_db($gmdb, $con);$perNumber=10;$page=$_GET['page'];$count=mysql_query("select count(*) from user");$rs=mysql_fetch_array($count);$totalNumber=$rs[0];$totalPage=ceil($totalNumber/$perNumber);if (!isset($page)){$page=1;}$startCount=($page-1)*$perNumber;$result=mysql_query("select * from user where  status NOT IN('proxy','admin') limit $startCount,$perNumber" );while ($row=mysql_fetch_array($result)){echo "<tr><td>$row[1]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]区</td><td>$row[6]</td><td>$row[7]</td><td><a href='proxyedit.php?id=$row[0]'>点击</a></td></tr>";}if ($page != 1){?>
		<tr><a href="gmlist.php?page=<?php echo $page - 1;?>">上一页</a></tr>
		<?php
 }for ($i=1;$i<=$totalPage;$i++){?>
		<tr><a href="gmlist.php?page=<?php echo $i;?>"><?php echo base64_decode('IOesrA==').' '.$i.' '.'页  ';?></a></tr>
		<?php
 }if ($page<$totalPage){?>
		<tr><a href="gmlist.php?page=<?php echo $page + 1;?>">下一页</a></tr>
		<?php
 }?>
     </table>
 <p class="admin_copyright"> &copy; 2019 Powered by 探花资源网</p> 
 </div>
</div>
</body>
</html>
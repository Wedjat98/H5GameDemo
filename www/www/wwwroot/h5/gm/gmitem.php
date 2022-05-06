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
    <title>GM</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
	</select> <script type="text/JavaScript">
       function gradeChange(){
        var select = document.getElementById("pid");
        var grade =  select.options[select.selectedIndex].grade;
        alert(grade);
       }
</script>
</head>
<body>
<?php
include base64_decode('Y29uZmlnLnBocA==');$mysqli =new mysqli($db_host,$db_username,$db_password,$gmdb,$dbport);if(!$mysqli){echo "<script>alert('系统提示：数据库连接失败');history.go(-1)</script>";exit;}session_start();$mysqli->set_charset('utf8');$query =$mysqli->prepare("select * from `user` where `user`=? and `password`=? limit 1");$query->bind_param('ss', $_SESSION["user"], $_SESSION["password"]);$query->execute();$result =$query->get_result();$row =mysqli_fetch_array($result);$check =md5($row['user'] . $row['password']);$status=$row['status'];if ($_SESSION['check'] <> $check || empty($_SESSION['status'])|| $_SESSION['status'] <> $status || $_SESSION['status'] <> 'admin'){unset($_SESSION);echo base64_decode('PHNjcmlwdD5hbGVydCgn5oKo5peg5q2k5p2D6ZmQ77yBJyk7d2luZG93LmxvY2F0aW9uLmhyZWY9J2luZGV4LnBocCc7PC9zY3JpcHQ+');exit;}if(isset($_SESSION['expiretime'])){if($_SESSION['expiretime'] < time()){unset($_SESSION['expiretime']);$query =$mysqli->prepare("INSERT INTO gmlog (user, create_time,name,remark,ip) VALUES (?, now(),?,'退出登陆',?)");$query->bind_param('sss', $_SESSION["user"], $_SESSION["name"], $user_IP);$query->execute();$mysqli->close();header(base64_decode('TG9jYXRpb246IGV4aXQucGhwP1RJTUVPVVQ='));exit(0);}else {$_SESSION['expiretime'] =time()+ 3600;}}?>
<div class="text-center col-md-4 center-block">
<h1><?php echo $_SESSION['gmbt'];?>授权后台</h1>
 <h3 style="color:blue"><?php echo $_SESSION['name'];?> 欢迎登陆</h3> <br>
	  <button class="btn btn-info btn-block" onclick="window.location.href='gmitem.php'">增删后台物品</button>	
	<button class="btn btn-info btn-block" onclick="window.location.href='gm.php'">返回主菜单</button>
	<button class="btn btn-info btn-block" onclick="window.location.href='exit.php'">登陆注销</button><br>	 
<form id="form1" name="form1" method="post" action="gmshowitem.php">
		 <label for="v">GM增删后台物品</label>
        <div class="form-group">
			<select class="form-control selectpicker" id="status" name="status" value="">
			<option value="">请选择</option>
			<option value="item">管理员</option>
			<option value="item2">VIP2</option>
			<option value="item3">VIP3</option>
			<option value="item4">VIP4</option>
			<option value="item5">VIP5</option>
			</select>
        </div>
    <div class="form-group">          
			<input type="text" placeholder="添加物品ID"  class="form-control" id="item" name="item" value="" >
			<input type="text" placeholder="添加物品名称"  class="form-control" id="itemname" name="itemname" value="" >
 <button type="submit" class="btn btn-info btn-block" name="sub" value="additem">添加</button><br>
         </div>	
	<div class="form-group"> 		 
 <input type="text" placeholder="输入要删除物品ID"  class="form-control" id="delitem" name="delitem" value="" >
 <button type="submit" class="btn btn-info btn-block" name="sub" value="delitem">删除</button>	<br>		 
	 </div>	 
		 <div class="form-group"> 
		 <button type="submit" class="btn btn-info btn-block" name="sub" value="show">显示物品列表</button><br>
		 </div>	 						
</form>
<h3 style="color:red">一键礼包物品</h3><br>
<form id="form2" name="form2" method="post" action="gmshowitem.php">
        <div class="form-group">
			<select class="form-control selectpicker" id="status" name="status" value="">
			<option value="">请选择</option>
			<option value="yz1">一键礼包1</option>
			<option value="yz2">一键礼包2</option>
			<option value="yz3">一键礼包3</option>
			<option value="yz4">一键礼包4</option>
			<option value="yz5">一键礼包5</option>
			<option value="yz6">一键礼包6</option>
			<option value="yz7">一键礼包7</option>
			<option value="yz8">一键礼包8</option>
			<option value="yz9">一键礼包9</option>
			<option value="yz10">一键礼包10</option>
			</select>
        </div>
    <div class="form-group">          
			<input type="text" placeholder="添加物品ID"  class="form-control" id="item" name="item" value="" >
			<input type="text" placeholder="数量"  class="form-control" id="num" name="num" value="" >
			<input type="text" placeholder="添加物品名称"  class="form-control" id="itemname" name="itemname" value="" >			
 <button type="submit" class="btn btn-info btn-block" name="sub" value="yzadditem">添加</button><br>
         </div>	
	<div class="form-group"> 		 
 <input type="text" placeholder="输入要删除物品ID"  class="form-control" id="delitem" name="delitem" value="" >
 <button type="submit" class="btn btn-info btn-block" name="sub" value="yzdelitem">删除</button>	<br>		 
	 </div>	 
		 <div class="form-group"> 
		 <button type="submit" class="btn btn-info btn-block" name="sub" value="yzshow">显示物品列表</button><br>
		 </div>	 						
</form>


<div class="form-group">
 <p class="admin_copyright"> &copy; 2019 Powered by 探花资源网</p> </div>
 
 </div>
</body>
</html>
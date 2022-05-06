<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>梦幻西游授权分级后台</title>
</head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GM</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<?php
session_start();
//此文件用与验证用户是否登陆，若以登陆则跳转到要访问界面，若没有登录则跳转到登陆界面。
if($_SESSION["user"] == ""){
	echo "<script>alert('您尚未登陆，请先登录后再访问！');window.location.href='index.php';</script>";
} 
if($_SESSION["status"] != 'admin'){
	echo "<script>alert('您无此权限！');window.location.href='index.php';</script>";	
}
?>
<div class="text-center col-md-4 center-block">
<h1>授权分级后台</h1>
 <h3 style="color:blue"><?php echo $_SESSION['name'];?> 欢迎登陆</h3> <br>
	<button class="btn btn-info btn-block" onclick="window.location.href='gm.php?page=1'">授权系统</button>
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmcz.php'">充值系统</button>
	 <button class="btn btn-info btn-block" onclick="window.location.href='mail.php'">邮件系统</button>
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmyz.php'">一键系统</button>	
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmother.php'">其他功能</button>	
	 <form id="form" name="form" method="post" action="addvip.php">
	 <button type="submit" class="btn btn-info btn-block" name="sub" value="logout">注销登录</button><br></form>
<form id="form1" name="form1" method="post" action="gmquery.php">
        <div class="form-group">
			<select class="form-control selectpicker" id="qu" name="qu" value="">
			<option value="1">一区</option>
			<option value="2">二区</option>
			<option value="3">三区</option>
			<option value="4">四区</option>
            <option value="5">五区</option> 
			</select>
            <label for="username">游戏角色名</label>
            <input type="text"  class="form-control" id="username" name="username" value="<?php echo $_SESSION['name'];?>" >
        </div>
    <div class="form-group">
            <label for="v">充值套餐</label>
			<select class="form-control selectpicker" id="goodsid" name="goodsid" value="">
				<option value="1">10元</option>
				<option value="2">100元</option>
				<option value="3">200元</option>
				<option value="4">300元</option>
				<option value="5">400元</option>
				<option value="6">500元</option>
				<option value="7">1000元</option>
				<option value="8">1500元</option>
				<option value="9">2000元</option>
				<option value="10">1800W元宝</option>
				<option value="11">2400W元宝</option>
				<option value="12">3000W元宝</option>
				<option value="13">3600W元宝</option>
				<option value="14">4500W元宝</option>
				<option value="15">5400W元宝</option>
				<option value="16">6000W元宝</option>
				<option value="17">7500W元宝</option>
				<option value="18">9000W元宝</option>
				<option value="19">月卡</option>
				<option value="20">周卡</option>
				<option value="38">终生卡</option>
			</select>
        </div>
        <button type="submit" class="btn btn-info btn-block" name="sub" value="cz">充值</button>		
</form>
<div class="form-group">
 <p
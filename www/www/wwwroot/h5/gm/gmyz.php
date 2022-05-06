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
    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<?php
include base64_decode('Y29uZmlnLnBocA==');$mysqli =new mysqli($db_host,$db_username,$db_password,$gmdb,$dbport);if(!$mysqli){echo "<script>alert('系统提示：数据库连接失败');history.go(-1)</script>";exit;}session_start();$mysqli->set_charset('utf8');$query =$mysqli->prepare("select * from `user` where `user`=? and `password`=? limit 1");$query->bind_param('ss', $_SESSION["user"], $_SESSION["password"]);$query->execute();$result =$query->get_result();$row =mysqli_fetch_array($result);$check =md5($row['user'] . $row['password']);$status=$row['status'];if ($_SESSION['check'] <> $check || empty($_SESSION['status'])|| $_SESSION['status'] <> $status || $_SESSION['status'] <> 'admin'){unset($_SESSION);echo base64_decode('PHNjcmlwdD5hbGVydCgn5oKo5peg5q2k5p2D6ZmQ77yBJyk7d2luZG93LmxvY2F0aW9uLmhyZWY9J2luZGV4LnBocCc7PC9zY3JpcHQ+');exit;}if(isset($_SESSION['expiretime'])){if($_SESSION['expiretime'] < time()){unset($_SESSION['expiretime']);$query =$mysqli->prepare("INSERT INTO gmlog (user, create_time,name,remark,ip) VALUES (?, now(),?,'退出登陆',?)");$query->bind_param('sss', $_SESSION["user"], $_SESSION["name"], $user_IP);$query->execute();$mysqli->close();header(base64_decode('TG9jYXRpb246IGV4aXQucGhwP1RJTUVPVVQ='));exit(0);}else {$_SESSION['expiretime'] =time()+ 3600;}}?>
<div class="text-center col-md-4 center-block">
<h1><?php echo $_SESSION['gmbt'];?>授权后台</h1>
 <h3 style="color:blue"><?php echo $_SESSION['name'];?> 欢迎登陆</h3> <br>
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmyz.php'">一键系统</button>	
	<button class="btn btn-info btn-block" onclick="window.location.href='gm.php'">返回主菜单</button>
	<button class="btn btn-info btn-block" onclick="window.location.href='exit.php'">登陆注销</button><br>		 
<form id="form1" name="form1" method="post" action="gmquery.php">
        <div class="form-group">
			<select class="form-control selectpicker" id="qu" name="qu" value="">
			<option value="1">一区</option>
			<option value="2">二区</option>
			<option value="3">三区</option>
			<option value="4">四区</option>
			</select>
            <label for="username">游戏账号或角色名</label>
            <input type="text"  class="form-control" id="username" name="username" value="<?php echo $_SESSION['name'];?>" >
        </div>
    <div class="form-group">		
				 <label style="color:red" >提示：修改yz.txt礼包对应的文件和数量</label><br>
		       <label style="color:blue">套餐礼包一</label>  <select class="form-control selectpicker" value="item">
		<?php
        $file = fopen("onekey/yz1.txt", "r");
        while(!feof($file))
        {
            $line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==3){
				echo '<option value="'.$txts[0].'">'.$txts[2].' '.'数量:'.$txts[1].'</option>';
			}
        }
        fclose($file);
			?>
			</select></br>	
        <button type="submit" class="btn btn-info btn-block" name="sub" value="yz1">一键发送套餐礼包一</button></br>	
       <label style="color:blue">套餐礼包二</label>  <select class="form-control selectpicker" value="item">
		<?php
        $file = fopen("onekey/yz2.txt", "r");
        while(!feof($file))
        {
            $line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==3){
				echo '<option value="'.$txts[0].'">'.$txts[2].' '.'数量:'.$txts[1].'</option>';
			}
        }
        fclose($file);
			?>
			</select>		
		<button type="submit" class="btn btn-info btn-block" name="sub" value="yz2">一键发送套餐礼包二</button></br>	
		  <label style="color:blue">套餐礼包三</label>  <select class="form-control selectpicker" value="item">
		<?php
        $file = fopen("onekey/yz3.txt", "r");
        while(!feof($file))
        {
            $line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==3){
				echo '<option value="'.$txts[0].'">'.$txts[2].' '.'数量:'.$txts[1].'</option>';
			}
        }
        fclose($file);
			?>
			</select>
		<button type="submit" class="btn btn-info btn-block" name="sub" value="yz3">一键发送套餐礼包三</button></br>	
		  <label style="color:blue">套餐礼包四</label>  <select class="form-control selectpicker" value="item">
		<?php
        $file = fopen("onekey/yz4.txt", "r");
        while(!feof($file))
        {
            $line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==3){
				echo '<option value="'.$txts[0].'">'.$txts[2].' '.'数量:'.$txts[1].'</option>';
			}
        }
        fclose($file);
			?>
			</select>
		<button type="submit" class="btn btn-info btn-block" name="sub" value="yz4">一键发送套餐礼包四</button></br>	
  <label style="color:blue">套餐礼包五</label>  <select class="form-control selectpicker" value="item">
		<?php
        $file = fopen("onekey/yz5.txt", "r");
        while(!feof($file))
        {
            $line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==3){
				echo '<option value="'.$txts[0].'">'.$txts[2].' '.'数量:'.$txts[1].'</option>';
			}
        }
        fclose($file);
			?>
			</select>	
		<button type="submit" class="btn btn-info btn-block" name="sub" value="yz5">一键发送套餐礼包五</button></br>	
 <label style="color:blue">套餐礼包六</label>  <select class="form-control selectpicker" value="item">
		<?php
        $file = fopen("onekey/yz6.txt", "r");
        while(!feof($file))
        {
            $line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==3){
				echo '<option value="'.$txts[0].'">'.$txts[2].' '.'数量:'.$txts[1].'</option>';
			}
        }
        fclose($file);
			?>
			</select>	
		<button type="submit" class="btn btn-info btn-block" name="sub" value="yz6">一键发送套餐礼包六</button></br>		
 <label style="color:blue">套餐礼包七</label>  <select class="form-control selectpicker" value="item">
		<?php
        $file = fopen("onekey/yz7.txt", "r");
        while(!feof($file))
        {
            $line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==3){
				echo '<option value="'.$txts[0].'">'.$txts[2].' '.'数量:'.$txts[1].'</option>';
			}
        }
        fclose($file);
			?>
			</select>	
		<button type="submit" class="btn btn-info btn-block" name="sub" value="yz7">一键发送套餐礼包七</button></br>		
 <label style="color:blue">套餐礼包八</label>  <select class="form-control selectpicker" value="item">
		<?php
        $file = fopen("onekey/yz8.txt", "r");
        while(!feof($file))
        {
            $line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==3){
				echo '<option value="'.$txts[0].'">'.$txts[2].' '.'数量:'.$txts[1].'</option>';
			}
        }
        fclose($file);
			?>
			</select>	
		<button type="submit" class="btn btn-info btn-block" name="sub" value="yz8">一键发送套餐礼包八</button></br>		
 <label style="color:blue" >套餐礼包九</label>  <select class="form-control selectpicker" value="item">
		<?php
        $file = fopen("onekey/yz9.txt", "r");
        while(!feof($file))
        {
            $line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==3){
				echo '<option value="'.$txts[0].'">'.$txts[2].' '.'数量:'.$txts[1].'</option>';
			}
        }
        fclose($file);
			?>
			</select>	
		<button type="submit" class="btn btn-info btn-block" name="sub" value="yz9">一键发送套餐礼包九</button></br>		
 <label style="color:blue">套餐礼包十</label>  <select class="form-control selectpicker" value="item">
		<?php
        $file = fopen("onekey/yz10.txt", "r");
        while(!feof($file))
        {
            $line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==3){
				echo '<option value="'.$txts[0].'">'.$txts[2].' '.'数量:'.$txts[1].'</option>';
			}
        }
        fclose($file);
			?>
			</select>	
		<button type="submit" class="btn btn-info btn-block" name="sub" value="yz10">一键发送套餐礼包十</button>			
        </div>				
</form>
 <p class="admin_copyright"> &copy; 2019 Powered by 探花资源网</p> </div>
</body>
</html>
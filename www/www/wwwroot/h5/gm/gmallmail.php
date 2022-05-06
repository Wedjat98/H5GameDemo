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
	<script src="js/jquery-1.7.2.min.js"></script>
</head>
<body>
<?php
include base64_decode('Y29uZmlnLnBocA==');$mysqli =new mysqli($db_host,$db_username,$db_password,$gmdb,$dbport);if(!$mysqli){echo "<script>alert('系统提示：数据库连接失败');history.go(-1)</script>";exit;}session_start();$mysqli->set_charset('utf8');$query =$mysqli->prepare("select * from `user` where `user`=? and `password`=? limit 1");$query->bind_param('ss', $_SESSION["user"], $_SESSION["password"]);$query->execute();$result =$query->get_result();$row =mysqli_fetch_array($result);$check =md5($row['user'] . $row['password']);$status=$row['status'];if ($_SESSION['check'] <> $check || empty($_SESSION['status'])|| $_SESSION['status'] <> $status || $_SESSION['status'] <> 'admin'){unset($_SESSION);echo base64_decode('PHNjcmlwdD5hbGVydCgn5oKo5peg5q2k5p2D6ZmQ77yBJyk7d2luZG93LmxvY2F0aW9uLmhyZWY9J2luZGV4LnBocCc7PC9zY3JpcHQ+');exit;}if(isset($_SESSION['expiretime'])){if($_SESSION['expiretime'] < time()){unset($_SESSION['expiretime']);$query =$mysqli->prepare("INSERT INTO gmlog (user, create_time,name,remark,ip) VALUES (?, now(),?,'退出登陆',?)");$query->bind_param('sss', $_SESSION["user"], $_SESSION["name"], $user_IP);$query->execute();$mysqli->close();header(base64_decode('TG9jYXRpb246IGV4aXQucGhwP1RJTUVPVVQ='));exit(0);}else {$_SESSION['expiretime'] =time()+ 3600;}}?>
<div class="text-center col-md-4 center-block">
<h1><?php echo $_SESSION['gmbt'];?>授权后台</h1>
 <h3 style="color:blue"><?php echo $_SESSION['name'];?> 欢迎登陆</h3> <br>
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmallmail.php'">全服邮件</button>
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
    <div class="form-group">
		<fieldset><legend>全服邮件系统</legend>
		  		<div class="form-group">
			<label for="itemtype">选择类型</label>
			<select class="form-control selectpicker" id="itemtype" name="itemtype" value="">
			<option value="1">物品</option>
             <option value="0">货币</option>                     
			</select>
			<label for="huobiid">选择货币</label>
			<select class="form-control selectpicker" id="huobiid" name="huobiid" value="">
							<option value="0">请选择</option>
							<option value="0">经验</option>
                            <option value="1">金币</option>
                            <option value="2">元宝</option>
                            <option value="3">绑定元宝</option>
			</select>													
	     <input type="text" value="" id="searchipt" placeholder="物品搜索" class="form-control"><input class="form-control" type="button" value="搜索" id="search" maxlength="20">
                  </div>  
			<div class="form-group">				  
         <select class="form-control selectpicker" id="item" name="item" value="item">
		<?php
        $file = fopen("onekey/item.txt", "r");
        while(!feof($file))
        {
            $line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==2){
				echo '<option value="'.$txts[0].'">'.$txts[1].'</option>';
			}
        }
        fclose($file);
			?>
			</select>
			<input type="text" placeholder="数量" class="form-control" id="num" name="num" value="1" maxlength="12"><br>
			<label for="level">等级大于多少发送</label>
			<input type="text" placeholder="请输入发送等级大于开始" class="form-control" id="level" name="level" value="" maxlength="6"><br>
		<div class="form-group">
		 <button type="submit" class="btn btn-info btn-block" name="sub" value="allmail">全服邮件发送</button>
		   </div>			
</form>
<script>
$('#search').click(function(){
	  var keyword=$('#searchipt').val();
	  $.ajax({
		  url:'itemquery.php',
		  type:'post',
		  'data':{keyword:keyword},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  if(data){
				  $('#item').html('');
				for (var i in data){
				  $('#item').append('<option value="'+data[i].key+'">'+data[i].val+'</option>');
				}
			  }else{
				  $('#item').html('<option value="0">未找到</option>');
			  }
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  </script>
<div class="form-group">
 <p class="admin_copyright"> &copy; 2019 Powered by 探花资源网QQ32368138,请保留.</p> </div>
</body>
</html>
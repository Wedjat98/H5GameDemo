<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>梦幻西游玩家后台</title>
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
	<script src="js/jquery-1.7.2.min.js"></script>
</head>
<body>
<?php
session_start();
//此文件用与验证用户是否登陆，若以登陆则跳转到要访问界面，若没有登录则跳转到登陆界面。
if($_SESSION["user"] == ""){
	echo "<script>alert('您尚未登陆，请先登录后再访问！');window.location.href='index.php';</script>";
} 
if($_SESSION["status"] != 'vip2' ){
	echo "<script>alert('您无此权限！');window.location.href='index.php';</script>";	
}
?>
<div class="text-center col-md-4 center-block">
<h1>梦幻西游玩家后台</h1>
 <h3 style="color:blue"><?php echo $_SESSION['name'];?> 欢迎登陆</h3> <br>
	 <button class="btn btn-info btn-block" onclick="window.location.href='player2.php'">充值系统</button>
	 <button class="btn btn-info btn-block" onclick="window.location.href='playermail2.php'">邮件系统</button>
	 <button class="btn btn-info btn-block" onclick="window.location.href='playerpass2.php'">修改密码</button><br>
	 <form id="form" name="form" method="post" action="addvip.php">
	 <button type="submit" class="btn btn-info btn-block" name="sub" value="logout">注销登录</button><br></form>
<form id="form1" name="form1" method="post" action="gmquery.php">
        <div class="form-group">
            <label for="qu">游戏分区</label>
            <input type="text" readOnly="true" class="form-control" id="qu" name="qu" value="<?php echo $_SESSION['qu'];?>区" >
            <label for="username">游戏角色名</label>
            <input type="text" readOnly="true" class="form-control" id="username" name="username" value="<?php echo $_SESSION['name'];?>" >
        </div>
    <div class="form-group">
		<fieldset><legend>邮件系统</legend>
		  		<div class="form-group">
			<label for="itemtype">选择类型</label>
			<select class="form-control selectpicker" id="itemtype" name="itemtype" value="">
                         <option value="0">货币</option> 
						<option value="1">物品</option>						                      
			</select>
			<label for="huobiid">选择货币</label>
			<select class="form-control selectpicker" id="huobiid" name="huobiid" value="">
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
        $file = fopen("item2.txt", "r");
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
			<input type="text" placeholder="数量" class="form-control" id="num" name="num" value="1" maxlength="9">
		<div class="form-group">
		 <button type="submit" class="btn btn-info btn-block" name="sub" value="mail">发送邮件</button>
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
 <p class="admin_copyright"> &copy; 2019 Powered by 陈橙子.</p> </div>
</body>
</html>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>百战沙城GM登录</title>
      <link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1>用户登录</h1>
			</div>
			<div class="login-form">
			  <form action="logincheck.php" method="post"> 
				<div class="control-group">
				<input type="text" class="login-field" name="username" value="" placeholder="角色UID" >
				<label class="login-field-icon fui-user" for="login-name"></label>
				</div>
				<div class="control-group">
				<input type="password" class="login-field" name="password" value="" placeholder="密码" >
				<label class="login-field-icon fui-lock" for="login-pass"></label>
				</div>
				<input class="btn btn-primary btn-large btn-block" type="submit" name="submit" value="登陆" />
			  <form />
			  <label class="login-field-icon fui-lock" for="login-pass">帐号填写你游戏帐号，统一授权密码：123456</label>
			</div>
		</div>
	</div>
</body>
</html>

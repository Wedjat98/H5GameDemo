<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>梦幻西游在线福利</title>
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
<div class="text-center col-md-4 center-block">
<h1>梦幻西游在线福利</h1>
<form id="form1" name="form1" method="post" action="fuliquery.php">
        <div class="form-group">
			<select class="form-control selectpicker" id="qu" name="qu" value="">
			<option value="1">一区</option>
			<option value="2">二区</option>
			</select>
            <label for="username">游戏角色名</label>
            <input type="text"  class="form-control" id="username" name="username" value="" >
        </div>
    <div class="form-group">
            <label for="v">赠送数量20W元宝</label>
		<input type="text" readOnly="true"  class="form-control" id="goodsid" name="goodsid" value="200000" >
        
        <button type="submit" class="btn btn-info btn-block" name="sub" value="cz">发送</button><br>	
  <label for="username">补偿福利</label>  <select class="form-control selectpicker" value="item">
		<?php
        $file = fopen("online.txt", "r");
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
		<button type="submit" class="btn btn-info btn-block" name="sub" value="online">一键发送补偿福利</button>	
        </div>				
</form>
<div class="form-group">
 <p class="admin_copyright"> &copy; 2019 Powered by 陈橙子.</p> </div>
 </div>
</body>
</html>
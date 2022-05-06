<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8"); 
include 'items.php';
?>
<?php require_once('conn.php'); ?>
<html>
<head>
<title>百战沙城_GM工具</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
<script src='jquery-1.7.2.min.js'></script>
  		<script src="http://www.84you.cn/jquery-2.2.4.min.js"></script>

		<script>
$(document).ready(function() {
				
				$(".form").slideDown(500);
				
				$("#landing").addClass("border-btn");

				$("#registered").click(function() {
					$("#landing").removeClass("border-btn");
					$("#landing-content").hide(500);
					$(this).addClass("border-btn");
					$("#registered-content").show(500);
					
				})

				$("#landing").click(function() {
					$("#registered").removeClass("border-btn");
					$(this).addClass("border-btn");
					
					$("#landing-content").show(500);
					$("#registered-content").hide(500);
				})
			});
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
        </script>
		<style>
			* {
				margin: 0;
				padding: 0;
				font-family: "微软雅黑";
			}
			
			body {
				background: #F7F7F7;
			}
			
			.form {
				position: absolute;
				top: 50%;
				left: 54%;
				margin-left: -185px;
				margin-top: -210px;
				height: 420px;
				width: 340px;
				font-size: 12px;
				-webkit-box-shadow: 0px 0px 10px #A6A6A6;
				background: #fff;
			}
			
			.border-btn {
				border-bottom: 1px solid #ccc;
			}
			
			#landing,
			#registered {
				float: left;
				text-align: center;
				width: 340px;
				padding: 15px 0;
				color: #545454;
			}
			
			#landing-content {
				clear: both;
			}
			
			.inp {
				height: 30px;
				margin: 0 auto;
				margin-bottom: 30px;
				width: 200px;
			}
			
			.inp>input {
				text-align: center;
				height: 27px;
				width: 200px;
				margin: 0 auto;
				transition: all 0.3s ease-in-out;
			}
			
			.login {
				border: 1px solid #A6A6A6;
				color: #a6a6a6;
				height: 30px;
				width: 202px;
				text-align: center;
				font-size: 13.333333px;
				margin-left: 70px;
				line-height: 30px;
				margin-top: 0px;
				transition: all 0.3s ease-in-out;
			}
			
			.login:hover {
				background: #A6A6A6;
				color: #fff;
			}
			
			#bottom {
				margin-top: 30px;
				font-size: 13.333333px;
				color: #a6a6a6;
			}
			
			#registeredtxt {
				float: left;
				margin-left: 80px;
			}
			
			#forgotpassword {
				float: right;
				margin-right: 80px;
			}
			
			#photo {
				border-radius: 80px;
				border: 1px solid #ccc;
				height: 80px;
				width: 80px;
				margin: 0 auto;
				overflow: hidden;
				clear: both;
				margin-top: 30px;
				margin-bottom: 30px;
			}
			
			#photo>img:hover {
				-webkit-transform: rotateZ(360deg);
				-moz-transform: rotateZ(360deg);
				-o-transform: rotateZ(360deg);
				-ms-transform: rotateZ(360deg);
				transform: rotateZ(360deg);
			}
			
			#photo>img {
				height: 80px;
				width: 80px;
				-webkit-background-size: 220px 220px;
				border-radius: 60px;
				-webkit-transition: -webkit-transform 1s linear;
				-moz-transition: -moz-transform 1s linear;
				-o-transition: -o-transform 1s linear;
				-ms-transition: -ms-transform 1s linear;
			}
			
			
			#registered-content {
				margin-top: 40px;
				display: none;
			}
			
			.fix {
				clear: both;
			}
			.form{
				display: none;
			}
		</style>
</head>
<body>
<?php
	if(isset($_POST["submit"]) && $_POST["submit"] == "登陆")
	{
		$user = $_POST["username"];
		$psw = $_POST["password"];
		if($user == "" || $psw == "")
		{ echo "<script>alert('请输入用户名或密码！'); history.go(-1);</script>"; }
		else
		{
	
			
			
			mysql_connect($host_t,$user_t,$pass_t);
			mysql_select_db($data_t);
			mysql_query("set names 'utf8'");
			$sql = "select * from qs where username = '$_POST[username]' and password = '$_POST[password]'";
			$result = mysql_query($sql);
			$num = mysql_num_rows($result);
			if($num)
			{// $row = mysql_fetch_array($result);	
			//数据以索引方式储存在数组中
			//	$uid=$row["username"];
			//echo "<script> alert('$uid')</script>";
			} else { echo "<script>alert('用户名或密码不正确！');history.go(-1);</script>"; }
		}
	}
	else
	{ echo "<script>alert('提交未成功！'); history.go(-1);</script>"; }
?>
  		<div class="form">
			<div id="landing">百战沙城GM管理</div>
            			<div class="fix"></div>
                        <div id="landing-content">

   <!--<div>GM校验码: <input type='password' value='c3' id='checknum' readonly></div> -->
	<input type='hidden' value='<?php echo $_POST['username'];?>' id='uid' readonly="readonly" placeholder="ID">
	<input type='hidden' value='1' id='qu' readonly="readonly" placeholder="区服" ></br></br>
	<div class="inp"><input  type='text' value='' placeholder="填写vip等级(1-20级)" maxlength="7" id='chargenum'></div>
	<div><input class="login" type='button' value='设置vip等级' id='chargebtn'></div></br></br>	
	<hr/>
    <br>
	   </select></div>
	<div><span>物品搜索: </span><input type='text' value='' id='searchipt' placeholder='物品搜索'><input type='button' value='搜索' id='search'></div>
    <div class="inp"><select id='mailid' >
      <option  value='1' >选择物品：</option>
    <?php
     $file = fopen("AGdDHnJ4lPkd1956_item3.txt", "r");
     while(!feof($file))
     {
       $line=fgets($file);
       $txts=explode(';',$line);
       echo '<option value="'.$txts[0].'">'.$txts[1].'</option>';
     }
     fclose($file);
    ?>
   </select></div>
     <div class="inp"><input  placeholder="物品数量" type='text' maxlength="9" value='' id='mailnum'></div>
     <div><input class="login" type='button' value='发送邮件' id='mailbtn'></div>
  </div>
 </div>
  
<script>
  var checknum='c3';
  var uid='<?php echo $_POST['username'];?>';
  var qu=$('#qu').val();
  $('#checknum').change(function(){
	  checknum=$(this).val();
  });
  $('#uid').change(function(){
	  uid=$.trim($(this).val());
  });
  $('#qu').change(function(){
	  qu=$.trim($(this).val());
  });
  $('#chargebtn').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('请联系管理员！');
		  return false;
	  }
	  if(qu=='0'){
		  alert('请选择游戏大区.');
		  return false;
	  }
	  var chargenum=$('#chargenum').val();
	  if(chargenum=='' || isNaN(chargenum)){
		  alert('充值元宝为空，请输入数量！');
		  return false;
	  }
	  if(chargenum<1 || chargenum>1000000000){
		  alert('充值数量:1-10亿。');
		  return false;
	  }
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'charge',checknum:checknum,uid:uid,num:chargenum,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('充值操作失败');
		  }
	  });
  });
  $('#mailbtn').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('用户名不能为空。');
		  return false;
	  }
	  var itemid=$('#mailid').val();
	  if(itemid=='10200001'){
		  alert('请选择物品。');
		  return false;
	  }
	  var groupnum=$('#mailid').find("option:selected").data("maxnum");
	  maxnum=groupnum*5;
	  var mailnum=$('#mailnum').val();
	  if(mailnum=='' || isNaN(mailnum)){
		  alert('物品数量不能为空。');
		  return false;
	  }
	  if(mailnum<1 || mailnum>maxnum){
		  alert('物品数量:1-'+maxnum+'。');
		  return false;
	  }
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'mail',checknum:checknum,uid:uid,item:itemid,num:mailnum,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  },
	  });
	  
  });
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
				  $('#mailid').html('');
				for (var i in data){
				  $('#mailid').append('<option value="'+data[i].key+'">'+data[i].val+'</option>');
				}
			  }else{
				  $('#mailid').html('<option value="0">未找到</option>');
			  }
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
</script>
</body>
</html>

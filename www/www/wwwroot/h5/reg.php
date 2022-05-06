<?php 
include_once "config.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>西游H5</title>
    <link rel="stylesheet" href="layui/css/layui.css" media="all">
    <style>
        body {
            margin: 10px;
        }

        .demo-carousel {
            height: 250px;
            line-height: 250px;
            text-align: center;
        }
		img{
 width:auto;
 height:auto;
 max-width:100%;
 max-height:100%;
}
    </style>
</head>

<body>
<!--<div class="layui-col-xs12 layui-col-md6">-->
 <div class="layui-carousel" id="test1">
  <div carousel-item="">
   <div><p class="layui-bg-green demo-carousel">欢迎来到西游H5!</p></div>
  </div>
</div>
    <div class="layui-tab layui-tab-brief" lay-filter="demo">
     <fieldset class="layui-elem-field layui-field-title">
  <div class="layui-form layui-form-pane">
  <div class="layui-field-box">
<!--begin--> 
 <div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li><a href="index.html">登入</a></li>
        <li class="layui-this">注册</li>
      </ul>
      <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <div class="layui-form layui-form-pane">
              <div class="layui-form-item">
			  <label for="L_qq" class="layui-form-label">QQ号码</label>
                <div class="layui-input-inline">
                  <input type="text" id="qq" name="qq" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">将会成为您唯一的密码找回凭证</div>
              </div>

              </div>
              <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">帐号</label>
                <div class="layui-input-inline">
                  <input type="text" id="username" name="username" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
				<div class="layui-form-mid layui-word-aux">6到16个字符</div>
              </div>
              <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="pass" name="pass" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到16个字符</div>
              </div>
              <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">确认密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="repass" name="repass" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">验证码</label>
                <div class="layui-input-inline">
                  <input type="text" name="vercode" id="vercode" required lay-verify="required" placeholder="请输入后面显示的验证码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">
                  <span style="color: #c00;"><img src="captcha.php?action=NUMBER" id="gvcode" onclick="javascript:this.src=this.src+'?time='+Math.random();" alt=""></span>
                </div>
              </div>
              <div class="layui-form-item">
               <button class="layui-btn" id="submit" name="submit" lay-filter="*">立即注册</button>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

 
<!--stop-->
  </div>
  <br>
<hr/>
  </div>
  </div>
</fieldset>

    <blockquote class="layui-elem-quote layui-quote-nm" id="footer"><ul class="list-inline list-unstyled navbar-footer">
	Copyright &copy; 2019 <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=86284186&site=qq&menu=yes">陈橙子 .All Rights Reserved.</a></li>
</blockquote>
<!--</div>-->
    
    <script src="layui/layui.js"></script>
	<script src='jquery-1.10.1.min.js'></script>
   <script>
layui.use(['laydate', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element'], function(){
  var laydate = layui.laydate //日期
  ,laypage = layui.laypage //分页
  layer = layui.layer //弹层
  ,table = layui.table //表格
  ,carousel = layui.carousel //轮播
  ,upload = layui.upload //上传
  ,element = layui.element; //元素操作 
layer.msg('欢迎来到西游H5');
             //执行一个轮播实例
            carousel.render({
                elem: '#test1'
				,width: '100%' //设置容器宽度
                ,height: 200 //设置容器高度
                ,anim: 'fade' //切换动画方式
				,interval: 5000
            });
           
            //底部信息
            var footerTpl = lay('#footer')[0].innerHTML;
            lay('#footer')[0].innerHTML = layui.laytpl(footerTpl).render({});
        }); 
 var username='';
 var pass='';
 var vercode='';
 var qq='';
 var repass='';
 $('#username').change(function(){
	 username=$(this).val();
  });
 $('#pass').change(function(){
	 pass=$(this).val();
  });
  $('#vercode').change(function(){
	 vercode=$(this).val();
  });
   $('#repass').change(function(){
	 repass=$(this).val();
  });
  $('#qq').change(function(){
	 qq=$(this).val();
  });
$('#submit').click(function(){
	if(username==''){
		layer.msg('账号不能为空');
		return false;
	}
	if(pass==''){
		layer.msg('密码不能为空');
		return false;
	}
	if(vercode==''){
		layer.msg('验证码不能为空');
		return false;
	}
	if(qq=='' || isNaN(qq))
	{
	layer.msg('QQ输入错误');
		return false;
	}
	if(pass!=repass){
	layer.msg('两次输入的密码不一致');
		return false;
	}
	layer.msg('正在为您提交注册中，请稍候');
	  $.ajax({
		  url:'action.php',
		  type:'post',
		  'data':{type:'reg',username:username,pass:pass,repass:repass,qq:qq,vercode:vercode,order:"<?php echo $order;?>"},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  layer.msg(data.info);
			  if(data.errcode==0){
				setTimeout(function () {location.href=data.url + "?order=<?php echo $order;?>";}, 1000);   
			  }
		  },
		  error:function(){
			  layer.msg('操作失败');
		  }
	  });
  });
    </script>
</body>

</html>

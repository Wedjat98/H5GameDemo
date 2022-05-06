<!DOCTYPE HTML>
<html style="font-size: 11px;">
<head>
    <meta name="applicable-device" content="mobile">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta content="width=device-width, initial-scale=1,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <!-- 游戏全屏 -->
    <meta content="true" name="full-screen"/>
    <meta content="true" name="x5-fullscreen"/>
    <meta content="true" name="360-fullscreen"/>
    <!--iphone qq -->
    <meta name="x5-orientation" content="portrait">
    <meta name="x5-fullscreen" content="true">
    <meta name="x5-page-mode" content="app">
    <title>梦幻西游</title>
    <meta name="description" content=""/>
    <link rel="stylesheet" href="/static/css/index.css?v20161122v3">
    <link rel="stylesheet" href="/static/css/h5sdk.css?v20161122v3">
    <link rel="stylesheet" href="/static/css/game.css?v20161122v3">
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/gdh5.min.js?v13"></script>
    <script type="text/javascript" src="/static/js/h5slider.1.0.js"></script>
    <script type="text/javascript">
        function is_mobile() {
            var screen = '';
            if(screen =='1'){
                $(".iframe_box").css("max-width", $(window).width())
                return true
            }
            var mobileAgent = new Array("iphone", "ipod", "ipad", "android", "mobile", "blackberry", "webos", "incognito", "webmate", "nokia", "ucweb", "skyfire");
            var ua = navigator.userAgent.toLowerCase();
            for (var i = 0; i < mobileAgent.length; i++) {
                if (ua.indexOf(mobileAgent[i]) != -1) {
                    return true
                }
            };
            return false
        }
        var game_id = '1';
        var game_name = 'H5';
        var domain = "url";
        var channel = '1';
        var uid = '';
        var mid = '1';
        var weixin = 'h5wyxzx';
        var weixinurl = '/static/img/gz_weixin.png';
        var showIcon = 1;
    </script>
</head>
<body>
<div>
    <div id="modal-button" class="modal-flag" style="display: block;">
        <img src="/static/img/fubiao.png">
    </div>
    <div class="moban" id="moban">
        <div class="modalframe">
            <div class="modal-content" id="modal-content">
                <section class="modal-main" id="modal-main">
                    <div class="modal-toper" id="user-info">
                        <!--<div class="toper-l"><img src="http://mfiles.gamedog.cn/H5/v2/img/logo.png"/>
                    </div>
                    -->
                        <div class="toper-m">
                            <p class="username">
                                梦幻西游
                            </p>
                        </div>
                    </div>
                    <div class="menu-list">
                        <ul class="menu-list-navbar">
                            <li id="nav-kf">
                                 <a href="tencent://AddContact/?fromId=45&fromSubId=1&subcmd=all&uin=1084855250&website=www.youhonglin.com"><img src="/static/img/kefu.png" alt="">
                                <p>
                                    点击联系客服
                                </p>  
                            <li id="nav-kf">
                                 <a href="https://jq.qq.com/?_wv=1027&k=5Hu1GKv"><img src="/static/img/kefu.png" alt="">
                                <p>
                                   点击加群
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="kefu list-item">
                        <p class="qq">
                            <a> 客服：</a>
                        </p>
                        <p class="1084855250">
                        </p>
                        <p class="qq">
                            <a> 玩家交流群：169324742</a>
                        </p>
                        <p class="qq_1">
                      </p>

                        <div class="toper-l"><img src="static/img/libao.png"/><font color="#FFF8DC" size="5" face="微软雅黑">礼包专区</font>
                    </div>                     
                    </div>
					<div>
                      <p><font color="#A52A2A" size="5">推广福利</font></p>                      
                      <p>每日推广送元宝*1E，5天送月卡，连续推广7天送死神太白</p> 
                      <p><font color="#A52A2A" size="5">游戏福利</font></p> 
                      <p>激活码：每日游戏主城签到送3000W元宝</p>
                      <p><font color="#A52A2A" size="5">激活码</font></p> 
                      <p>激活码：qwer123456789qwer</p>
                      <p>激活立得元宝*1E+神秘宠物一只</p>
					    <p>探花云科技官网：https://th.mdhzi.cn</p>
					<li></li>
                      </p>
                    </div>
                </section>
            </div>
        </div>
        <div id="modal-left" class="modal-left">
            <img src="/static/img/modalleft.png">
        </div>
    </div>
</div>
<div id="games-root" style="opacity: 1;">
    <div class="iframe_box" id="games-container">
        <iframe id="game_iframe" name ="game_iframe" frameborder="no" src="/login.php" scrolling="no" width='100%' height='100%'>
        </iframe>
    </div>
    <div class="left-tool-cont" id="leftbox" style="display: none;">
        <div id="slide-runner">
        </div>
        <div id="gifts-cont">
            <div class="users-comments" id="xglb_box">
                <div class="u-l-title">
                    相关礼包
                </div>
                <div class="lb-cont" id="xglb">
                </div>
            </div>
            <div id="game-comm">
                <div class="users-comments">
                    <div class="u-r-title">
                        热门推荐
                    </div>
                    <div class="hot-com" id="rmtj">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $("#shouji").click(function(){
                $("#libaosaoma").hide();
                $("#shoujisaoma").slideToggle();
            });
            $("#libao").click(function(){
                $("#shoujisaoma").hide();
                $("#libaosaoma").slideToggle();
            });
        })
    </script>
</div>
<script language="javascript">
    //检测src
    $(document).ready(function(){
        pushHistory();  var ismobile = is_mobile();
        if(ismobile){
        }else{
            //$("#leftbox").show();
            $("#rightbox").show();
            //getBoxInfo2(game_name);
            //getRmtjBox();
            //getPicBox();
        }
    });
    function pushHistory() {
        var state = {
            title: document.title,
            url: location.href
        };
        window.history.pushState(state, document.title, location.href);
    };
    //相关礼包
    function getBoxInfo2(game_name){
        var domain = "gamedog.cn";
        if(game_name!==''){
            var keyword = game_name;
            $.getJSON("http://h5.m."+domain+"/index.php?m=Apisdk&a=lists&callback=?&keyword="+keyword,function(data){
                var str = "";
                var sum = data.list.length;
                var round = Math.round(Math.random()*(sum-1));
                str += '<div class="swiper-wrapper">';
                str2 = ''
                if(data.list!==''){
                    $.each(data.list, function(i,item){
                        if(i==round){
                            str2 += item.icon;
                            str += '<span><img src="'+item.icon+'" /></span><h2>'+item.title+'</h2><p>'+item.reward+'</p><a href="javascript:void(0);" onclick="getLibaopc('+item.aid+')">领取</a></div>';
                        }
                    })
                }
                str += '</div>';
                $('#xglb').empty().append(str);
                if(str2==''){
                    $("#xglb_box").hide();
                }
            })
        }
    }
    //热门推荐游戏
    function getRmtjBox(){
        $.getJSON("http://h5.m."+domain+"/index.php?m=Apisdk&a=getGameList&pageSize=4&flag=d,a&isopen=sdk&order=weight&callback=?",function(data){
            var str = "";
            if(data.lists!==''){
                $.each(data.lists, function(i,item){
                    if(i<=4){
                        str += '<div class="swiper-wrapper">'
                        str += '<span><img src="'+item.icon+'" /></span><h2>'+item.title+'</h2><p>'+item.description+'</p><a href="http://h5.'+domain+'/games/'+item.id+'.html" target="_blank">开始游戏</a></div>';
                        str += '</div>';
                    }
                })
            }
            $('#rmtj').empty().append(str);
        })
    }
    //轮播图
    function getPicBox(){
        $.getJSON("http://h5.m."+domain+"/index.php?m=Apisdk&a=getpiclists&callback=?",function(data){
            var str = "";
            if(data.list!==''){
                $.each(data.list, function(i,item){
                    str += '<a href="'+item.arcurl+'" target="_blank"><img src="'+item.litpic+'" style="width:350px;height:156px;"/></a>';
                })
            }
            $('#slide-runner').empty().append(str);
            slider.init({obj:'#slide-runner'});
        })
    }
    var ajaxstatuska = 0
    //领取礼包
    function getLibaopc(hid){
        $("#hao-box").remove();
        if(ajaxstatuska==1){
            return false;
        }
        ajaxstatuska = 1;
        $.getJSON("http://ka."+domain+"/index.php?m=Ajax&a=linghao&type=mobile&callback=?&aid="+hid+"&class=h5sdk",function(data){
            ajaxstatuska = 0;
            var str = '';
            if(data.stater==="-3"){
                alert("活动已经结束")
            }else if(data.stater==="-2"){
                alert("您来晚了,号码没有了!")
            }else if(data.stater==="-1"){
                alert("登录过期,请重新登录!")
                oBoxHide();
            }else if(data.stater==="1"){
                var str = '';
                str += '<div class="fuchuangpc fk-boxpc" id="hao-box" style="z-index:3000;">';
                str += '<dl>';
                str += '    <dt class="k">礼包内容：</dt>';
                str += '      <dt id="hao-con">'+data.body+'</dt>';
                str += '      <dt class="k">兑换方式：</dt>';
                str += '      <dt id="hao-cash" onmouseover="mouseOver()" onmouseout="mouseOut()">'+data.introduction+'</dt>';
                str += '      <dt class="l" id="hao-number"><span>'+data.number+'</span></dt>';
                str += '      <dt class="f" id="wbk" style="display:none;">'+data.introduction+'</dt>';
                str += '  </dl>';
                str += '  <div class="ca"><a href="javascript:;" onclick="close_kapc()"></a></div>';
                str += '</div>';
                $('body').before('<div class="jqmOverlay" style="height: 100%; width: 100%; position: fixed; left: 0px; top: 0px; z-index: 1010; opacity: 0.5;background-color:#000;"></div>');
                $('body').append(str);
                return false;
            }else if(data.stater==='2'){ //今天已经领过了
                str += '<div class="fuchuangpc fk-boxpc" id="hao-box" style="z-index:3000;">';
                str += '<dl>';
                str += '    <dt class="k">礼包内容：</dt>';
                str += '      <dt id="hao-con">'+data.body+'</dt>';
                str += '      <dt class="k">兑换方式：</dt>';
                str += '      <dt id="hao-cash">'+data.introduction+'</dt>';
                str += '      <dt class="l" id="hao-number"><span>'+data.number+'</span></dt>';
                str += '      <dt class="f"><a href="javascript:;">长按上方卡号复制</a></dt>';
                str += '  </dl>';
                str += '  <div class="ca"><a href="javascript:;" onclick="close_kapc()"></a></div>';
                str += '</div>';
                $('body').before('<div class="jqmOverlay" style="height: 100%; width: 100%; position: fixed; left: 0px; top: 0px; z-index: 1010; opacity: 0.5;background-color:#000;"></div>');
                $('body').append(str);
                return false;
            }else if(data.stater==="-4"){
                alert("同IP一天只能领取3次")
            }else{
                alert("非法操作")
            }
        });
    }
    function close_kapc(){
        $(".jqmOverlay").remove();
        $(".fk-boxpc").remove();
    }
    function mouseOver(){
        $("#wbk").show();
    }
    function mouseOut(){
        $("#wbk").hide();
    }
</script>
</body>
</html>
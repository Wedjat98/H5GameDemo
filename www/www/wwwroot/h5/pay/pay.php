<?php
$a1=$_POST['a1'];     //�û���
$cny=$_POST['cny'];  //��ֵ���
$a3=$_POST['a3'];   //��ֵ��ʽ

$pay1="315@315.men";//֧�����տ��˺�
$pay2="38238300";//�Ƹ�ͨ�տ��˺�

//-------------֧������ת��ʼ
if($a3==1){
?>
<html>
<head>
<meta charset="gb2312">
<title>������ת��֧��ҳ��...&#25628;&#34382;&#31934;&#21697;&#31038;&#21306;&#119;&#119;&#119;&#46;&#115;&#111;&#117;&#104;&#111;&#46;&#110;&#101;&#116;&#25552;&#20379;&#25903;&#20184;&#23453;&#21644;&#36130;&#20184;&#36890;&#20813;&#31614;&#32422;&#21363;&#26102;&#21040;&#24080;&#25509;&#21475;</title>
</head>
<body>
<form id="alipaysubmit" name="alipaysubmit" action="http://www.56ziyuan.com/yqm" method="POST">
  <input type="hidden" name="optEmail" value="<?php echo $pay1;?>"/>
  <input type="hidden" name="payAmount" value="<?php echo $cny;?>"/>
  <input type="hidden" name="title" value="<?php echo $a1;?>"/>
  <input type="hidden" name="memo" value="�벻Ҫ�޸ĸ���˵���������,�����޷��Զ���ɶ���"/>
  <!--<input type="hidden" value="submit" value="����Ϊ����ת��֧��������ҳ��,��δ�Զ�ת������...">-->
  <input type="hidden" value="submit" value="sending...click here...">
</form>
<script type="text/javascript">
   document.forms['alipaysubmit'].submit();
</script>
</body>
</html>
<?php
}
//-------------֧��������

//-------------�Ƹ�ͨ��ת��ʼ
if($a3==2){
$md5=md5($pay2."&".$cny."&".$a1); //�������ݺ�ʹ��MD5���ܣ�Ȼ����ת�Ƹ�ͨ���
?>
<html>
<head>
<meta charset="gb2312">
<title>������ת���Ƹ�֧ͨ��ҳ��...&#25628;&#34382;&#31934;&#21697;&#31038;&#21306;&#119;&#119;&#119;&#46;&#115;&#111;&#117;&#104;&#111;&#46;&#110;&#101;&#116;&#25552;&#20379;&#25903;&#20184;&#23453;&#21644;&#36130;&#20184;&#36890;&#20813;&#31614;&#32422;&#21363;&#26102;&#21040;&#24080;&#25509;&#21475;</title>
</head>
<body>
<form id="alipaysubmit" action="https://www.tenpay.com/v2/account/pay/paymore_cft.shtml?data=<?php echo $pay2;?>%26<?php echo $cny;?>%26<?php echo $a1;?>&validate=<?php echo $md5;?>" method="post">
<!--<input type="hidden" value="submit" value="����Ϊ����ת���Ƹ�ͨ����ҳ��,��δ�Զ�ת������...">-->
<input type="hidden" value="submit" value="sending...click here...">
</form>
<script type="text/javascript">
   document.forms['alipaysubmit'].submit();
</script>
</body>
</html>
<?php
}
?>
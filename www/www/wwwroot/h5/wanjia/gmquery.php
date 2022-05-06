<?php
include 'telnet.class.php';
if($_POST){
	$quarr=array(
		1=>array(
			'ip'=>'192.168.1.37',
			'gm_port'=>3306,
			'gmcode'=>'520'
		)
	);
	$log='./gm.log';
	$checknum=trim($_POST['checknum']);
	if($checknum!='c3'){
		$return=array(
			'errcode'=>1,
			'info'=>'GM校验码错误，请联系管理员。',
		);
		exit(json_encode($return));
	}
	$quid=intval($_POST['qu']);
	$qu=$quarr[$quid];
	if($qu==null){
		$return=array(
			'errcode'=>1,
			'info'=>'请选择游戏大区！',
		);
		exit(json_encode($return));
	}
	$uid=$_POST['uid'];


	if($_POST['type']){
		$coon =mysqli_connect('127.0.0.1','root','123456','bzsc_h5_s1','3306') or die('数据库连接错误!');
		$coon->query('set names utf8');	
		$type=trim($_POST['type']);
		switch ($type){
			case 'charge':
                $res = mysqli_fetch_assoc($coon->query("SELECT id FROM player WHERE accname='$uid'"));
                $wp = $res['id'];
                $num = intval($_POST['num']);
                $sql = "UPDATE player_vip SET level=$num WHERE (role_id ='$wp') LIMIT 1";
                if ($coon->query($sql)){
					$return=array(
						'errcode'=>0,
						'info'=>'vip等级设置成功!',
					);
					exit(json_encode($return));					
				}else{
					$return=array(
						'errcode'=>1,
						'info'=>'vip等级设置失败!',
					);
					exit(json_encode($return));						
				}
					
				break;
			case 'mail':
				$itemid=trim($_POST['item']);
				$num=intval($_POST['num']);
				if($num==0){
					$return=array(
						'errcode'=>1,
						'info'=>'邮件数量错误。',
					);
					exit(json_encode($return));
				}
				

                $item = "[{" . $itemid . "," . $num . "}]";
                $res = mysqli_fetch_assoc($coon->query("SELECT id FROM player WHERE accname='$uid'"));
                $wp = $res['id'];
				$sql = "insert into player_mail (`type`, `send_role_id`, `rec_role_id`, `title`, `content`, `read`, `award`, `accessory`, `ctime`) values('0','1','$wp','系统邮件','GM邮件','0','0','$item',unix_timestamp(now()))";
                if ($coon->query($sql)){
					$return=array(
						'errcode'=>0,
						'info'=>'邮件发送成功。'
					);
					exit(json_encode($return));					
				}else{
					$return=array(
						'errcode'=>1,
						'info'=>'邮件发送失败。'
					);
					exit(json_encode($return));						
					
				}				
				break;
			default:
				$dbh = null;
				$return=array(
					'errcode'=>1,
					'info'=>'类型错误。',
				);
				exit(json_encode($return));
				break;
		}
	}else{
		$dbh = null;
		$return=array(
			'errcode'=>1,
			'info'=>'类型错误。',
		);
		exit(json_encode($return));
	}
}else{
	$return=array(
		'errcode'=>1,
		'info'=>'must post',
	);
	exit(json_encode($return));
}

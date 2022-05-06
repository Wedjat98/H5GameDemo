<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/2/26
 * Time: 下午5:44
 */
include_once ('../../config.php');
$code = $_POST['code'];
$platform = $_POST['platform'];
$player_id = $_POST['player_id'];
$server_id = $_POST['server_id'];
$sign = $_POST['sign'];
//2018年04月10日增加验证

$md5 = md5("code=$code&platform=$platform&player_id=$player_id&server_id=$server_id".$key);
if($md5 == $sign) {
    $db = "bzsc_h5_s" . $server_id;
    $sql = "use $db;";
    $pdo->query($sql);
    $sql = "select * from `web`.`cdk` where cdk = '" . $code . "';";
    $sql_result = $pdo->query($sql);
    $cdk = $sql_result->fetchAll();
    if (count($cdk) != 0) {
        $sql = "select * from `web`.`cdk` where use_role = '" . $player_id . "' and server_id = '$server_id' and cdk_id = " . $cdk[0]['cdk_id'] . ";";
        $sql_result = $pdo->query($sql);
        $cdk1 = $sql_result->fetchAll();
        if (count($cdk1) == 0) {
            //发送
            $time = time();
            $platform = 'h5game';
            $server_num = $server_id;
            $do = 5;
            $enter_ticket = '7YnELt8MmA4jVED7';
            $sql = "insert into `" . $db . "`.`player_mail` ( `rec_role_id`, `content`, `send_role_id`, `title`, `read`, `accessory`, `ctime`, `type`, `award`) values ( '" . $player_id . "', '礼包！', '0', '礼包', '0', '" . $cdk[0]['items'] . "', '" . $time . "', '1', '0')";
            $pdo->query($sql);
            $sql = "select * from `" . $db . "`.`player_mail` where `rec_role_id` = '" . $player_id . "' and `title` = '礼包' and ctime = " . $time . ";";
            $sql_result = $pdo->query($sql);
            $mail = $sql_result->fetchAll();
            $data = '[{' . $player_id . ',' . $mail[0]['id'] . '}]';
            $token = md5($platform . $server_num . $do . $data . $time . $enter_ticket);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "http://221.229.166.148:800" . ($server_num - 1) . "/background?platform=$platform&server_num=$server_num&do=$do&token=$token&time=$time&data=$data");
            curl_setopt($curl, CURLOPT_HEADER, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($curl);
            curl_close($curl);
            //记录
            $sql = "update `web`.`cdk` set use_role = $player_id , use_time = $time, server_id = $server_num where cdk = '" . $code . "';";
            $result = $pdo->query($sql);
            $result = array("code" => "1000",);
        } else {
            $result = array("code" => "1007", "data" => "该账号已领取过");
        }
    } else {
        $result = array("code" => "1007", "data" => "礼包码无效");
    }
}else{
    $result = array("code" => "1007", "data" => "error");
}
echo base64_encode(json_encode($result));
?>
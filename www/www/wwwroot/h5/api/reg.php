<?php
/**
 * 不要修改此版权，否则死全家！
 * @date: 2018年5月7日 下午8:13:29
 * @author: 欢乐逗(QQ:1242821087)
 **/
header("content-type:text/html;charset=utf-8");
date_default_timezone_set('Asia/Shanghai');
include "config/config.php";
$act = getstr('act');
if ($act = 'reg') {
    $account = poststr('username');
    $pwd = poststr('password');
    $repwd = poststr('password1');
    $time = date('Y-m-d h:i:s');
    if (preg_match('/^[0-9a-zA-Z]+$/', $account)) {
        if (strlen($pwd) >= 6) {
            if ($repwd == $pwd) {
                $anums = dbtotal("web", "user", "account= '" . $account . "'");
                if ($anums < 1) {
                    $sql = "INSERT INTO web.user (`account`, `password`, `createTime`) VALUES ('" . $account . "', '" . $repwd . "', '" . $time . "')";
                    $result = mysql_query($sql, $conn);
                    if ($result) {
                        $row = dbselect("web", "user", "account= '" . $account . "'");
                        $lacc = $row['account'];
                        $data = array(
                            'code' => 1,
                            'user' => $lacc,
                            'msg' => '注册成功'
                        );
                    } else {
                        $data = array(
                            'code' => 0,
                            'msg' => '注册失败'
                        );
                    }
                } else {
                    $data = array(
                        'code' => 0,
                        'msg' => '账号已存在'
                    );
                }
            } else {
                $data = array(
                    'code' => 0,
                    'msg' => '两次密码输入不一致'
                );
            }
        } else {
            $data = array(
                'code' => 0,
                'msg' => '密码必须是大于6位的字母或者数字'
            );
        }
    } else {
        $data = array(
            'code' => 0,
            'msg' => '账号必须是大于6位的字母或者数字'
        );
    }
    mysql_close($conn);
}
echo json_encode($data, true);
?>
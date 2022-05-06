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
if ($act = 'login') {
    $account = poststr('username');
    $pwd = poststr('password');
    if (preg_match('/^[0-9a-zA-Z]+$/', $account)) {
        $anums = dbtotal("web", "user", "account= '" . $account . "'");
        $row = dbselect("web", "user", "account= '" . $account . "'");
        if ($anums >= 1) {
            if ($row['password'] == $pwd) {
                $lacc = $row['account'];
                $lpwd = $row['password'];
                $ltime = $row['createTime'];
                $data = array(
                    'code' => 1,
                    'user' => $lacc,
                    'msg' => 'ok'
                );
            } else {
                $data = array(
                    'code' => 0,
                    'msg' => '账号或密码错误'
                );
            }
        } else {
            $data = array(
                'code' => 0,
                'msg' => '账号不存在'
            );
        }
    } else {
        $data = array(
            'code' => 0,
            'msg' => '账号不允许有中文'
        );
    }
    mysql_close($conn);
}
echo json_encode($data, true);
?>
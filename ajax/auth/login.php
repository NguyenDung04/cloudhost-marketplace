<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'LOGIN') {
        $username = antixss($_POST['username']);
        $password = antixss($_POST['password']);
        $check = $ketnoi->get_row("SELECT * FROM `users` WHERE `username` = '$username'");
        if($username == "" || $password == ""){
            json_Msg('error','Vui lòng nhập đủ thông tin');
        }elseif(!$check){
            json_Msg('error','Tài khoản không tồn tại');
        }elseif(verify_password($password, $check['password'])){
            json_Msg('error','Mật khẩu không tính xác');
        } else {
            $ss_token = random('0123456789qwertyuiopasdfghjlkzxcvbnmQEWRWROIWCJHSCNJKFBJWQ', 32);
            $ketnoi->begin_transaction();
            $update = $ketnoi->update("users",array(
                'ip_adr' => $ip,
                'address' => check_address($ip),
                'time' => $now,
                'session_token' => $ss_token
            ),"`username` = '$username'");
            $his_login = $ketnoi->insert("his_login",array(
                'username' => $username,
                'title' => 'Đăng nhập hệ thống',
                'browser' => getTrinhDuyet(),
                'device' => getOS(),
                'ip' => $ip,
                'address' => check_address($ip),
                'time' => $now
            ));
            if($update && $his_login){
                $ketnoi->commit();
                $_SESSION['session'] = $ss_token;
                json_Msg('success','Đăng nhập thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error','Đăng nhập thất bại');
            } 
        }
    } 
}

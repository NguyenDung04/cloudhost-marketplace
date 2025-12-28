<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
// Xử lý đăng ký
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'REGISTER') {
        $username = antixss($_POST['username']);
        $email = antixss($_POST['email']);
        $password = antixss($_POST['password']);
        $confirmpassword = antixss($_POST['confirmpassword']);
        $phone = antixss($_POST['phone']);
        $check_user = $ketnoi->get_row("SELECT * FROM `users` WHERE `username` = '$username'");
        $check_email = $ketnoi->get_row("SELECT * FROM `users` WHERE `email` = '$email'");
        if($username == "" || $password == "" || $email == "" || $confirmpassword == "" || $phone == ""){
            json_Msg('error','Vui lòng điền đầy đủ thông tin');
        }elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            json_MSg('error','Tên đăng nhập không gồm ký tự đặc biệt và dấu');
        }elseif($check_user){
            json_Msg('error','Người dùng đã tồn tại');
        }elseif(strlen($username) < 5 || strlen($username) > 20){
            json_Msg('error','Tên đăng nhập phải tối thiểu 5 ký tự và tối đa 20 ký tự');
        }elseif($check_email){
            json_Msg('error','Email đã được sử dụng');
        }elseif(!preg_match("/^[a-zA-Z0-9_.+-]+@gmail\.com$/", $email)){
            json_Msg('error','Email không hợp lệ');
        }else{
            $ketnoi->begin_transaction();
            $ss_token = random('0123456789qwertyuiopasdfghjlkzxcvbnmQEWRWROIWCJHSCNJKFBJWQ', 32);
            $pass_new = TypePassword($password);
            $insert = $ketnoi->insert("users",array(
                'username' => $username,
                'password' => $pass_new,
                'email' => $email,
                'phone' => $phone,
                'money' => 0,
                'total_money' => 0,
                'session_token' => $ss_token,
                'level' => 1,
                'band' => 0,
                'ip_adr' => $ip,
                'createdate' => $now,
                'time' => $now,
                'tb_email' => 'off',
                'tb_tele' => 'off',
                'veri_email' => 'off',
                'address' => check_address($ip)
            ));
            if($insert){
                $ketnoi->commit();
                $_SESSION['session'] = $ss_token;
                json_Msg('success','Đăng ký thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error','Đăng ký thất bại');
            }
        }
    }
}
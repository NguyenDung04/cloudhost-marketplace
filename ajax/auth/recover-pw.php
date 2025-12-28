<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'RECOVER_PW') {
        $email = antixss($_POST['email']);
        $check = $ketnoi->get_row("SELECT * FROM `users` WHERE `email` = '$email'");
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif($email == ""){
            json_Msg('error','Vui lòng nhập email');
        }elseif(!$check){
            json_Msg('error', 'Email không tồn tại');
        }else{
            $random_pw = random('0123456789qwertyuiopasdfghjlkzxcvbnmQEWRWROIWCJHSCNJKFBJWQ', 32);
            $pass_new = TypePassword($random_pw);
            $ketnoi->begin_transaction();
            $update = $ketnoi->update("users",array(
                'password' => $pass_new
            ),"`email` = '$email'");
            if($update){
                $ketnoi->commit();
                json_Msg('success', 'Mật khẩu mới đã gửi tới email của bạn');
                sendMail($email, $check['username'], "Đặt lại mật khẩu", "Mật khẩu mới của bạn là: " . $random_pw, "", "");
            }else{
                $ketnoi->rollback();
                json_Msg('error', 'Đặt mật khẩu thất bại');
            }
        }
    }
}
<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
// Xử lý đổi mật khẩu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     if (isset($_POST['action']) && $_POST['action'] == 'SEND_MAIL') {
        $check = $ketnoi->get_row("SELECT * FROM `users` WHERE `username` = '$username'");
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }else{
            $random_otp = random('0123456789', 6);
            $ketnoi->begin_transaction();
            $update = $ketnoi->update("users",array(
                'veri_otp' => $random_otp
            ),"`username` = '$username'");
            if($update){
                $ketnoi->commit();
                json_Msg('success', 'Mã đã được gửi về mail');
            }else{
                $ketnoi->rollback();
                json_Msg('error', 'Đã xảy ra lỗi trong quá trình gửi mail');
            }
        }
     }elseif(isset($_POST['action']) && $_POST['action'] == 'VERI_MAIL'){
        $otp_Email = antixss($_POST['otpEmail']);
        $check = $ketnoi->get_row("SELECT * FROM `users` WHERE `username` = '$username'");
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif($check['veri_email'] == 'on'){
            json_Msg('error', 'Email đã được xác thực');
        }elseif($otp_Email == "" ){
            json_Msg('error', 'Vui lòng nhập otp');
        }elseif(strlen($otp_Email) != 6 ){
             json_Msg('error', 'Otp gồm 6 chữ số');
        }elseif($check['veri_otp'] != $otp_Email){
             json_Msg('error', 'Otp không tính xác');
        }elseif($check['veri_email'] == 'on'){
             json_Msg('error', 'Email đã được xác thực');
        }else{
            $ketnoi->begin_transaction();
            $update = $ketnoi->update("users",array(
                'veri_email' => 'on'
            ),"`username` = '$username'");
            if($update){
                $ketnoi->commit();
                json_Msg('success', 'Xác thực email thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error', 'Đã xảy ra lỗi trong quá trình xác thực');
            }
        }
     }
}
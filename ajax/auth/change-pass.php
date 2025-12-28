<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
// Xử lý đổi mật khẩu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'CHANGE_PASS') {
        $password_old = antixss($_POST['passwordOld']);
        $password_new = antixss($_POST['passwordNew']);
        $password_cf = antixss($_POST['passwordCf']);
         $check = $ketnoi->get_row("SELECT * FROM `users` WHERE `username` = '$username'");
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif($password_old == "" || $password_new == "" || $password_cf == ""){
            json_Msg('error','Vui lòng nhập đủ thông tin');
        }elseif(!verify_password($password_old, $check['password'])){
            json_Msg('error','Mật khẩu cũ không tính xác');
        }elseif(strlen($password_new)<6  || strlen($password_cf)<6 ){
            json_Msg('error','Độ dài mật khẩu phải lớn hơn 6 kí tự');
        }elseif($password_new != $password_cf){
            json_Msg('error','Nhập lại mật khẩu không khớp');
        }else {
             $pass_new = TypePassword($password_cf);
             $ketnoi->begin_transaction();
             $update = $ketnoi->update("users",array(
                 'password'=> $pass_new
            ),"`username` = '$username'");
            if($update){
                $ketnoi->commit();
                json_Msg('success', 'Đổi mật khẩu thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error', 'Đổi mật khẩu thất bại');
            }
        }
    }
}
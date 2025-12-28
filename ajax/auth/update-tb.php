<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
// Xử lý đổi mật khẩu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     if (isset($_POST['action']) && $_POST['action'] == 'tele') {
          $status = antixss($_POST['status']);
          $check = $ketnoi->get_row("SELECT * FROM `users` WHERE `username` = '$username'");
          if(!checkUser($username , $session)){
                json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
          }
          if($check['tb_email'] == 'on'){
               json_Msg('error', 'Bạn đã bật thông báo email rồi');
          }
          $ketnoi->begin_transaction();
             $update = $ketnoi->update("users",array(
                 'tb_tele'=> $status
            ),"`username` = '$username'");
            
            if($update){
                $ketnoi->commit();
                json_Msg('success', 'Cập nhật thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error', 'Cập nhật thất bại');
            }
     }elseif(isset($_POST['action']) && $_POST['action'] == 'email'){
         $status = antixss($_POST['status']);
          $check = $ketnoi->get_row("SELECT * FROM `users` WHERE `username` = '$username'");
          if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
          }
          if($check['tb_tele'] == 'on'){
               json_Msg('error', 'Bạn đã bật thông báo tele rồi');
          }
          $ketnoi->begin_transaction();
             $update = $ketnoi->update("users",array(
                 'tb_email'=> $status
            ),"`username` = '$username'");
            
            if($update){
                $ketnoi->commit();
                json_Msg('success', 'Cập nhật thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error', 'Cập nhật thất bại');
            }
     }elseif (isset($_POST['action']) && $_POST['action'] == 'update-tb') {
        $id_tele = antixss($_POST['id_tele'] ?? '');
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }
        if (empty($id_tele)) {
            json_Msg('error', 'Vui lòng nhập ID Telegram');
        }
        $check = $ketnoi->get_row("SELECT * FROM `users` WHERE `username` = '$username'");
        if (!$check) {
            json_Msg('error', 'Không tìm thấy tài khoản');
        }
        $ketnoi->begin_transaction();
        $update = $ketnoi->update("users", array(
            'id_tele' => $id_tele
        ), "`username` = '$username'");
        if ($update) {
            $ketnoi->commit();
            json_Msg('success', 'Đã lưu ID Telegram thành công');
        } else {
            $ketnoi->rollback();
            json_Msg('error', 'Không thể lưu ID Telegram');
        }
    }
}
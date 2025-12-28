<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'CHANGE_API_TOKEN') {
    if(!checkUser($username , $session)){
        json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
    }
    $newToken = encryptData(random('0123456789qwertyuiopasdfghjlkzxcvbnmQEWRWROIWCJHSCNJKFBJWQ',32));
    $update = $ketnoi->update("users", array(
        'token' => $newToken
    ), "`username` = '$username'");
    if ($update) {
        json_Msg('success', 'Đổi token thành công');
    } else {
        json_Msg('error', 'Đổi token thất bại');
    }
}
?>
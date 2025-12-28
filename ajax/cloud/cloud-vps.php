<?php 
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/cloud-vps.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'BUY_VPS') {
        $total = loadPrice($_POST);
        $total_money = $total['amount_raw'];
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif($total['status'] == '1'){
            if($user['money'] < $total_money){
                json_Msg('error','Số dư của bạn không đủ');
            }else{
                $ketnoi->begin_transaction();
                $update_user = $ketnoi->tru('users','money', $total_money, "`username` = '$username'");
                if($update_user){
                    $creat_vps = creatVps($_POST['vpsid'], $_POST['billingcycle'],$_POST['os'], $_POST['cpu'], $_POST['ram'], $_POST['disk']);
                    if (!is_array($creat_vps) || !isset($creat_vps['data'][0])) {
                        $ketnoi->rollback();
                        json_Msg('error', 'Không thể tạo VPS. Máy chủ API không trả dữ liệu hợp lệ');
                    }
                    $data = [
                        'ip' => 'Đang khởi tạo',
                        'cpu' => 0,
                        'ram' => 0,
                        'disk' => 0,
                        'text-config' => '0 CPU - 0 RAM - 0 Disk',
                        'day-left' => 'Đang khởi tạo',
                        'username' => 'Đang khởi tạo',
                        'password' => 'Đang khởi tạo',
                        'vps-status' => 'progressing'
                    ];
                    $vps_info = $creat_vps['data'][0];
                    $vps_id   = $vps_info['vps-id'] ?? null;
                    $insert_vps = $ketnoi->insert("purchased_cloudvps",array(
                        'username' => $username,
                        'id_produc' => $_POST['vpsid'],
                        'id_vps' => $vps_id,
                        'billingcycle' => $_POST['billingcycle'],
                        'billingcycleday' => 30,
                        'data' => json_encode($data, JSON_UNESCAPED_UNICODE),
                        'info' => json_encode($creat_vps['data'], JSON_UNESCAPED_UNICODE),
                        'status' => 'progressing',
                        'money' => $total_money,
                        'cost' => $total_money,
                        'total_money' => $total_money,
                        'total_cost' => $total_money,
                        'created_at' => $now,
                        'updated_at' => $now,
                        'site' => 'CHINHAPI'
                    ));
                    $code = random('0123456789qwertyuiopasdfghjlkzxcvbnmQEWRWROIWCJHSCNJKFBJWQ', 5);
                    $insert_order = $ketnoi->insert("orders",array(
                        'username' => $username,
                        'name' => 'test',
                        'billing_cycle' => $_POST['billingcycle'],
                        'code' => $code,
                        'quantity' => 1,
                        'total_money' => $total_money,
                        'created_at' => $now,
                        'status' => 'thanhcong',
                    ));
                    $insert_invoice = $ketnoi->insert("invoices",array(
                        'username' => $username,
                        'id_oder' => $code,
                        'title' => 'Đặt hàng VPS',
                        'time' => $now,
                    ));
                    if($creat_vps['error'] == 0 || $insert_vps || $insert_order){
                        $ketnoi->commit();
                        json_Msg('success','Thanh toán thành công');
                    }else{
                        $ketnoi->rollback();
                        json_Msg('error','Thanh toán thất bại');    
                    }
                }else{
                    $ketnoi->rollback();
                    json_Msg('error','Thanh toán thất bại');    
                }
            }
        }else{
            json_Msg('error',$total['msg']);
        }
    } elseif(isset($_POST['action']) && $_POST['action'] == 'ACTION_VPS'){
        $action_vps = antixss($_POST['action_vps']);
        $id_vps = antixss($_POST['id_vps']);
        $check = $ketnoi->get_row("SELECT * FROM `purchased_cloudvps` WHERE `id_vps` = '$id_vps' AND `username` = '$username'");
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif($action_vps == $check['status']){
            json_Msg('error', 'Vps đã được thực hiện hành động này');
        }elseif($action_vps == 'rebuild' || $check['status'] == 'cancel' || $check['status'] == 'delete_vps'){
            json_Msg('error', 'Vps đang trong quá trình cài đặt lại , không thể thao tác');
        }else{
            $ketnoi->begin_transaction();
            if($action_vps == 'restart'){
                $action_vps = 'on';
            }
            $update_action = $ketnoi->update("purchased_cloudvps",array(
                'status' => $action_vps
            ),"`id_vps` = '$id_vps'");
            $action_vps = actionVps($action_vps, $id_vps);
            if(isset($action_vps['error']) && $action_vps['error'] != 0){
                json_Msg('error',$action_vps['message']);
            }
            if($update_action && $action_vps){
                $ketnoi->commit();
                json_Msg('success','Thao tác vps thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error','Thao tác vps thất bại');
            }
        }
    } elseif(isset($_POST['action']) && $_POST['action'] == 'REBUILD_VPS'){
        $id_vps = antixss($_POST['id_vps']);
        $id_os = antixss($_POST['id_os']);
        $check_vps = $ketnoi->get_row("SELECT * FROM `purchased_cloudvps` WHERE `id_vps` = '$id_vps' AND `username` = '$username'");
        $check_os = $ketnoi->get_row("SELECT * FROM `img_os` WHERE `id_os` = '$id_os'");
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif(!$check_vps){
            json_Msg('error', 'VPS không tồn tại');
        }elseif(!$check_os){
            json_Msg('error', 'Hệ điều hành không tồn tại');
        }else{
            $old_info = json_decode($check_vps['info'], true) ?? [];
            if (isset($old_info[0])) {
                $old_info[0]['vps_os'] = $check_os['os_name']; 
            } else {
                $old_info = [[
                    'vps-id'  => $id_vps,
                    'vps_os'  => $check_os['os_name']
                ]];
            }
            $ketnoi->begin_transaction();
            $update_vps = $ketnoi->update("purchased_cloudvps",array(
                'info'   => json_encode($old_info, JSON_UNESCAPED_UNICODE),
                'status' => 'progressing'
            ),"`id_vps` = '$id_vps'");
            $reinstall_vps = reinstallVPS($id_vps, $id_os);
            if($update_vps && $reinstall_vps){
                $ketnoi->commit();
                json_Msg('success','Cài đặt lại thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error','Cài đặt lại thất bại');
            }
        }
    } elseif(isset($_POST['action']) && $_POST['action'] == 'RENEW_VPS'){
        $vps_id = antixss($_POST['vps_id']);
        $billing_cycle = antixss($_POST['billing_cycle']);
        $check_vps = $ketnoi->get_row("SELECT * FROM `purchased_cloudvps` WHERE `id_vps` = '$vps_id' AND `username` = '$username'");
        $check_cycle = checkCycle($billing_cycle);
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif(!$check_vps){
            json_Msg('error', 'VPS không tồn tại');
        }elseif(!$check_cycle){
            json_Msg('error', 'Chu kỳ gia hạn không hợp lệ');
        }elseif($check_vps['money'] > $user['money']){
            json_Msg('error', 'Số dư của bạn không đủ');
        }else{
            $months = $check_cycle['months'];
            if($check_vps['end_date'] < $now){
                $end_date = $now + ($months * 2592000);
            }else{
                $end_date = $check_vps['end_date'] + ($months * 2592000);
            }
            $ketnoi->begin_transaction();
            $update_user = $ketnoi->tru("users","money",$check_vps['money'],"`username` = '$username'");
            $update_time = $ketnoi->update("purchased_cloudvps",array(
                'end_date' => $end_date
            ),"`id_vps` = '$vps_id'");
            $renew_vps = renewVps($vps_id, $billing_cycle);
            if($renew_vps['error'] == 1){
                json_Msg('error',$renew_vps['message']);
            }elseif($update_user && $update_time && $renew_vps){
                $ketnoi->commit();
                json_Msg('success','Gia hạn thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error','Gia hạn thất bại');
            }
        }
    }elseif(isset($_POST['action']) && $_POST['action'] == 'CHANGE_USER'){
        $vps_id = antixss($_POST['id_vps']);
        $new_user = antixss($_POST['email']);
        $check_vps = $ketnoi->get_row("SELECT * FROM `purchased_cloudvps` WHERE `id_vps` = '$vps_id' AND `username` = '$username'");
        $check_user = $ketnoi->get_row("SELECT * FROM `users` WHERE `email` = '$new_user'");
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif($new_user== ""){
            json_Msg('error','Vui lòng nhập email');
        }elseif(!$check_vps){
            json_Msg('error', 'VPS không tồn tại');
        }elseif(!$check_user){
            json_Msg('error', 'Email không tồn tại');
        }elseif($user['email'] == $new_user){
            json_Msg('error','Không thể chuyển cho chính mình');
        }elseif( $user['money'] < 1000){
            json_Msg('error', 'Số dư của bạn không đủ');
        }else{
            $ketnoi->begin_transaction();
            $update_vps = $ketnoi->update("purchased_cloudvps",array(
                'username' => $check_user['username'],
            ),"`id_vps` = '$vps_id'");
            $update_money = $ketnoi->tru("users","money",1000,"`username` = '$username'");
            if($update_vps && $update_money){
                $ketnoi->commit();
                json_Msg('success','Chuyển quyền thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error','Chuyển quyền thất bại');
            }
        }
    }
}
// function creatVps($id_vps, $months, $os, $cpu, $ram, $disk) {
//     $fake_ip = '160.250.' . rand(100, 255) . '.' . rand(10, 255);
//     $fake_pass = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 12);
//     $date_create = date('d-m-Y');
//     $next_due_date = date('Y-m-d', strtotime('+1 month'));
//     $response = [
//         "error" => 0,
//         "message" => "Đặt hàng thành công",
//         "credit" => 50000,
//         "total" => 50000,
//         "data" => [[
//             "vps-id" => random(4000, 9999),
//             "date_create" => $date_create,
//             "next_due_date" => $next_due_date,
//             "vps-status" => "progressing",
//             "is-special" => 0,
//             "ip" => $fake_ip,
//             "username" => "root",
//             "password" => $fake_pass,
//             "service_type" => "vps",
//             "vps_os" => $os
//         ]]
//     ];
//     return $response;
// }
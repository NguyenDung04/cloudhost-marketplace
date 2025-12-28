<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/hosting.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'BUY_HOST') {
        $id_host = antixss($_POST['id_host']);
        $month = antixss($_POST['month']);
        $discount = antixss($_POST['discount']);
        $domain = antixss($_POST['domain']);
        $check = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `id` = '$id_host' AND `status` = 'on'");
        $check_id = $check['server_host'];
        $sv_host = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$check_id'");
        $price = $check['money'] * $month ; 
            if ($month == 12) {
                $price -= $price * 0.1;
            } elseif ($month == 24) {
                $price -= $price * 0.2;
            } elseif ($month == 60) {
                $price -= $price * 0.4;
            }
        $total_money = checkDiscount($price, $discount);
        if (!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif($id_host == "" || $month == "" || $discount == "" || $domain == ""){
            json_Msg('error','Thiếu thông tin');
        }elseif(!$check){
            json_Msg('error','Hosting không tồn tại');
        }elseif(strpos($domain, '.') < -1) {
            json_Msg('error','Tên miền bạn nhập không hợp lệ!!');
        }elseif($total_money > $user['money']){
            json_Msg('error','Số dư của bạn không đủ');
        }elseif($ketnoi->get_row("SELECT * FROM `history_buy_hosting` WHERE `domain` = '$domain'")){
            json_Msg('error','Tên miền đã tồn tại');
        }else{
            $ketnoi->begin_transaction();
            $update_user = $ketnoi->tru('users','money', $total_money, "`username` = '$username'");
            $password = 'C@'.random('0123456789qwertyuiopasdfghjlkzxcvbnmQEWRWROIWCJHSCNJKFBJWQ', 12);
            if($update_user){
                $insert_hosting = $ketnoi->insert('history_buy_hosting',array(
                    'username' => $username,
                    'domain' => $domain,
                    'pk_host' => $check['code_host'],
                    'sv_host' => $check['server_host'],
                    'money' => $check['money'],
                    'total_money' => $total_money,
                    'account' => encryptData(to_slug($domain)),
                    'password' => encryptData($password),
                    'creatAt' => $now,
                    'endAt' => $now + $month * 30 * 24 * 60 * 60 ,
                    'status' => 'active',
                    'note' => 'Hoàn tất',
                    'time' => $now,
                ));
                $code = random('0123456789qwertyuiopasdfghjlkzxcvbnmQEWRWROIWCJHSCNJKFBJWQ', 5);
                $insert_order = $ketnoi->insert('orders',array(
                    'username' => $username,
                    'name' => $check['name_host'],
                    'code' => $code,
                    'billing_cycle' => checkCycle($month),
                    'created_at' => $now,
                    'quantity' => 1,
                    'total_money' => $total_money,
                    'balance_before' => $user['money'],
                    'balance_after' => $user['money'] - $total_money,
                    'status' => 'thanhcong',
                ));
                $insert_invoice = $ketnoi->insert('invoices',array(
                    'username' => $username,
                    'id_oder' => $code,
                    'title' => 'Đặt hàng Hosting',
                    'time' => $now,
                ));
                $api_host = createHost($sv_host['ip_whm'], $sv_host['account_whm'], $sv_host['password_whm'], to_slug($domain) ,$domain, 'chinhapiit@gmail.com', $sv_host['account_whm'] . '_' . $check['code_host'], $password);
                if(isset($api_host['metadata']['result'])){
                    if($insert_hosting || $insert_order || $insert_invoice ){
                        $ketnoi->commit();
                        json_Msg('success','Thanh toán thành công');
                    }else{
                        $ketnoi->rollback();
                        json_Msg('error','Thanh toán thất bại');
                    }
                }else{
                    $ketnoi->rollback();
                    json_Msg('error','Đã xảy ra lỗi khi tạo hosting');
                }
            }else{
                $ketnoi->rollback();
                json_Msg('error','Thanh toán thất bại');
            }
        }
    }elseif(isset($_POST['action']) && $_POST['action'] == 'INFO_HOST'){
        $id_host = antixss($_POST['id_host']);
        $check = $ketnoi->get_row("SELECT * FROM `history_buy_hosting` WHERE `id` = '$id_host' AND `username` = '$username'");
        $check_id = $check['sv_host'];
        $sv_host = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$check_id'");
        if(!$check){
            json_Msg('error','Hosting ko tồn tại');
        }
        $data = getInfoHost($sv_host['ip_whm'], decodecryptData($check['account']), decodecryptData($check['password']));
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }elseif(isset($_POST['action']) && $_POST['action'] == 'CHANGE_PASS'){
        $id_host = antixss($_POST['id_host']);
        $password = antixss($_POST['password']);
        $check = $ketnoi->get_row("SELECT * FROM `history_buy_hosting` WHERE `id` = '$id_host'");
        $check_pk = $check['pk_host'];
        $pk_host = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `code_host` = '$check_pk'");
        $check_id = $pk_host['server_host'];
        $sv_host = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$check_id'");
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif($id_host == "" || $password == ""){
            json_Msg('error','Thiếu thông tin');
        }elseif(!$check){
            json_Msg('error','Hosting ko tồn tại');
        }elseif(strlen($password) < 8 || strlen($password) > 50){
            json_Msg('error','Mật khẩu phải có ít nhất 8 kí tự và không được vượt quá 50 kí tự');
        }elseif (!preg_match('/[A-Z]/', $password)) {
            json_Msg('error','Mật khẩu phải có ít nhất 1 ký tự in hoa');
        }elseif (!preg_match('/[0-9]/', $password)) {
            json_Msg('error','Mật khẩu phải có ít nhất 1 số');
        }elseif (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
            json_Msg('error','Mật khẩu phải có ít nhất 1 ký tự đặc biệt');
        }elseif(preg_match('/\s/', $password)){
            json_Msg('error', 'Mật khẩu không được chứa khoảng trắng');
        }else{
            $ketnoi->begin_transaction();
            $update_password = $ketnoi->update('history_buy_hosting',array(
                'password' => encryptData($password),
            ), "`id` = '$id_host'");
            $api_host = changePassHost($sv_host['ip_whm'], ($sv_host['account_whm']), ($sv_host['password_whm']), decodecryptData($check['account']), $password);
            if($update_password && $api_host){
                $ketnoi->commit();
                json_Msg('success','Đổi mật khẩu thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error','Đổi mật khẩu thất bại');
            }
        }
    }elseif(isset($_POST['action']) && $_POST['action'] == 'LOGIN_CPANEL'){
        $id_host = antixss($_POST['id_host']);
        $check = $ketnoi->get_row("SELECT * FROM `history_buy_hosting` WHERE `id` = '$id_host'");
        $check_pk = $check['pk_host'];
        $pk_host = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `code_host` = '$check_pk'");
        $check_id = $pk_host['server_host'];
        $sv_host = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$check_id'");
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif(!$check || !$sv_host){
            json_Msg('error', 'Hosting ko tồn tại');
        }else{
            $data = loginCpanel($sv_host['ip_whm'], ($sv_host['account_whm']), ($sv_host['password_whm']), decodecryptData($check['account']), 'cpaneld');
            if (isset($data['metadata']['result']) && $data['metadata']['result'] == 1) {
                exit(json_encode([
                    'status' => 'success',
                    'url' => $data['data']['url']
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }else{
                json_Msg('error', 'Mở cPanel thất bại');
            }
        }
    }elseif(isset($_POST['action']) && $_POST['action'] == 'CHANGE_DOMAIN'){
        $id_host = antixss($_POST['id_host']);
        $domain = antixss($_POST['domain']);
        $check = $ketnoi->get_row("SELECT * FROM `history_buy_hosting` WHERE `id` = '$id_host'");
        $check_pk = $check['pk_host'];
        $pk_host = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `code_host` = '$check_pk'");
        $check_id = $pk_host['server_host'];
        $sv_host = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$check_id'");
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif(!$check || !$sv_host){
            json_Msg('error', 'Hosting ko tồn tại');
        }elseif(strpos($domain, '.') < -1) {
            json_Msg('error','Tên miền bạn nhập không hợp lệ!!');
        }elseif($ketnoi->get_row("SELECT * FROM `history_buy_hosting` WHERE `domain` = '$domain'")){
            json_Msg('error','Tên miền đã tồn tại');
        }else{
            $ketnoi->begin_transaction();
            $update_domain = $ketnoi->update('history_buy_hosting',array(
                'domain' => $domain,
            ), "`id` = '$id_host'");
            $api_host = changeDomainHost($sv_host['ip_whm'], ($sv_host['account_whm']), ($sv_host['password_whm']), decodecryptData($check['account']), $domain);
            if($update_domain && $api_host['metadata']['result'] == 1){
                $ketnoi->commit();
                json_Msg('success','Đổi tên miền thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error','Đổi tên miền thất bại');
            }
        }
    }elseif(isset($_POST['action']) && $_POST['action'] == 'RENEW_HOST'){
        $id_host = antixss($_POST['id_host']);
        $cycle = antixss($_POST['cycle']);
        $check_cycle = checkCycle($cycle);
        $check = $ketnoi->get_row("SELECT * FROM `history_buy_hosting` WHERE `id` = '$id_host' AND `username` = '$username'");
        $check_pk = $check['pk_host'];
        $pk_host = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `code_host` = '$check_pk'");
        $check_id = $pk_host['server_host'];
        $sv_host = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$check_id'");
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif(!$check || !$sv_host){
            json_Msg('error', 'Hosting ko tồn tại');
        }elseif($cycle == ""){
            json_Msg('error', 'Vui lòng chọn chu kỳ gia hạn');
        }elseif(!$check_cycle){
            json_Msg('error', 'Chu kỳ gia hạn không hợp lệ');
        }elseif($check['money'] > $user['money']){
            json_Msg('error', 'Số dư của bạn không đủ');
        }else{
            $months = $check_cycle['months'];
            if($check['endAt'] < $now){
                $end_date = $now + ($months * 2592000);
            }else{
                $end_date = $check['endAt'] + ($months * 2592000);
            }
            $ketnoi->begin_transaction();
            $update_user = $ketnoi->tru("users","money",$check['money'],"`username` = '$username'");
            $update_time = $ketnoi->update("history_buy_hosting",array(
                'endAt' => $end_date,
            ),"`id` = '$id_host' ");
            if($update_user && $update_time){
                $ketnoi->commit();
                json_Msg('success','Gia hạn thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error','Gia hạn thất bại');
            }
        }
    }elseif(isset($_POST['action']) && $_POST['action'] == 'CHANGE_USER'){
        $id_host = antixss($_POST['id_host']);
        $email = antixss($_POST['email']);
        $check = $ketnoi->get_row("SELECT * FROM `history_buy_hosting` WHERE `id` = '$id_host' AND `username` = '$username'");
        $check_pk = $check['pk_host'];
        $pk_host = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `code_host` = '$check_pk'");
        $check_id = $pk_host['server_host'];
        $sv_host = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$check_id'");
        $check_user = $ketnoi->get_row("SELECT * FROM `users` WHERE `email` = '$email'");
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif(!$check || !$sv_host){
            json_Msg('error', 'Hosting ko tồn tại');
        }elseif($email == ""){
            json_Msg('error', 'Vui lòng nhập email');
        }elseif ($ketnoi->num_rows("SELECT * FROM `users` WHERE `email` = '$email'") == 0) {
            json_Msg('error', 'Email chưa đăng ký');
        }elseif($user['email'] == $email){
            json_Msg('error','Không thể chuyển cho chính mình');
        }elseif( $user['money'] < 1000){
            json_Msg('error', 'Số dư của bạn không đủ');
        }else{
            $ketnoi->begin_transaction();
            $update_host = $ketnoi->update("history_buy_hosting",array(
                'username' => $check_user['username'],
            ),"`id` = '$id_host'");
            $update_money = $ketnoi->tru("users","money",1000,"`username` = '$username'");
            if($update_host && $update_money){
                $ketnoi->commit();
                json_Msg('success','Chuyển quản trị viên thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error','Chuyển quản trị viên thất bại');
            }
        }
    }elseif(isset($_POST['action']) && $_POST['action'] == 'DELETE_HOST'){
        $id_host = antixss($_POST['id_host']);
        $check = $ketnoi->get_row("SELECT * FROM `history_buy_hosting` WHERE `id` = '$id_host' AND `username` = '$username'");
        $check_pk = $check['pk_host'];
        $pk_host = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `code_host` = '$check_pk'");
        $check_id = $pk_host['server_host'];
        $sv_host = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$check_id'");        
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif(!$check){
            json_Msg('error', 'Hosting ko tồn tại');
        }else{
            $ketnoi->begin_transaction();
            $delete_host = $ketnoi->update("history_buy_hosting",array(
                'status' => 'delete_vps',
                'note' => 'Người dùng xóa'
            ),"`id` = '$id_host'");
            $api_host = suspendacctHost($sv_host['ip_whm'], ($sv_host['account_whm']), ($sv_host['password_whm']), decodecryptData($check['account']), 'Tạm khóa , khách hủy');
            if($delete_host && $api_host['metadata']['result'] == 1){
                $ketnoi->commit();
                json_Msg('success','Xóa hosting thành công');
            }else{
                $ketnoi->rollback();
                json_Msg('error','Xóa hosting thất bại');
            }
        }
    }
}

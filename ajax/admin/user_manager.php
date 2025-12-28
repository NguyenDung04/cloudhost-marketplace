<?php
require $_SERVER["DOCUMENT_ROOT"] . "/core/db.php"; 

// ==================== XỬ LÝ REQUEST ====================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
    
    $action = $_POST["action"] ?? ""; 

    if ($action == "EDIT_USER") {
        $id = (int)($_POST["id"] ?? 0);
        $fullname = trim(antixss($_POST["fullname"] ?? ""));
        $email = trim(antixss($_POST["email"] ?? ""));
        $phone = trim(antixss($_POST["phone"] ?? ""));
        $address = trim(antixss($_POST["address"] ?? ""));
        $level = (int)($_POST["level"] ?? 0);

        // ===== VALIDATE DỮ LIỆU =====
        if ($id <= 0) {
            json_Msg("error", "Thiếu ID cần cập nhật");
        }
        
        if (empty($fullname)) {
            json_Msg("error", "Họ tên không được để trống");
        }
        
        if (mb_strlen($fullname, 'UTF-8') < 2) {
            json_Msg("error", "Họ tên phải có ít nhất 2 ký tự");
        }

        // Validate email
        $emailCheck = validateEmail($email);
        if (!$emailCheck['status']) {
            json_Msg("error", $emailCheck['message']);
        }

        // Validate phone
        $phoneCheck = validatePhone($phone);
        if (!$phoneCheck['status']) {
            json_Msg("error", $phoneCheck['message']);
        }
        
        // Format phone nếu valid
        $phone = $phoneCheck['formatted'] ?? $phone;

        // Validate level
        if (!in_array($level, [0, 1])) {
            json_Msg("error", "Level không hợp lệ");
        }

        // Kiểm tra user tồn tại
        $check = $ketnoi->get_row("SELECT * FROM `users` WHERE `id` = '$id'");
        if (!$check) {
            json_Msg("error", "Người dùng không tồn tại");
        }

        // Kiểm tra email trùng
        if (!empty($email) && $email !== $check['email']) {
            $email_check = $ketnoi->get_row("SELECT id FROM `users` WHERE `email` = '$email' AND `id` != '$id'");
            if ($email_check) {
                json_Msg("error", "Email này đã được sử dụng bởi người dùng khác");
            }
        }

        // Kiểm tra phone trùng
        if (!empty($phone) && $phone !== $check['phone']) {
            $phone_check = $ketnoi->get_row("SELECT id FROM `users` WHERE `phone` = '$phone' AND `id` != '$id'");
            if ($phone_check) {
                json_Msg("error", "Số điện thoại này đã được sử dụng bởi người dùng khác");
            }
        }

        // ===== CẬP NHẬT DATABASE =====
        $ketnoi->begin_transaction();
        
        try {
            $update_data = array(
                "fullname" => $fullname,
                "email" => $email,
                "phone" => $phone,
                "address" => $address,
                "level" => $level,
                "time" => time()
            );
            
            $update = $ketnoi->update("users", $update_data, "`id` = '$id'");

            if (!$update) {
                throw new Exception("Không thể cập nhật thông tin người dùng");
            }

            $ketnoi->commit();
            
            // Trả về response thành công
            exit(json_encode([
                'status' => 'success',
                'msg' => 'Cập nhật thông tin thành công',
                'data' => [
                    'id' => $id,
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone' => $phone,
                    'level' => $level,
                    'address' => $address,
                    'updated_time' => date('H:i:s d/m/Y', time())
                ]
            ]));
            
        } catch (Exception $e) {
            $ketnoi->rollback();
            json_Msg("error", $e->getMessage());
        }

    } elseif ($action == "UPDATE_BAND_STATUS") {
        $id = (int)($_POST["id"] ?? 0);
        $band = (int)($_POST["band"] ?? 0);

        if ($id <= 0) {
            json_Msg("error", "Thiếu ID cần cập nhật");
        }

        if (!in_array($band, [0, 1])) {
            json_Msg("error", "Giá trị band không hợp lệ");
        }

        $check = $ketnoi->get_row("SELECT * FROM `users` WHERE `id` = '$id'");
        if (!$check) {
            json_Msg("error", "Người dùng không tồn tại");
        }

        $ketnoi->begin_transaction();
        
        try {
            $update = $ketnoi->update("users", ["band" => $band, "time" => time()], "`id` = '$id'");

            if (!$update) {
                throw new Exception("Không thể cập nhật trạng thái");
            }

            $ketnoi->commit();
            json_Msg("success", "Cập nhật trạng thái thành công");
            
        } catch (Exception $e) {
            $ketnoi->rollback();
            json_Msg("error", $e->getMessage());
        }

    } elseif ($action == "ADJUST_MONEY") {
        $user_id = (int)($_POST["user_id"] ?? 0);
        $amount = (int)($_POST["amount"] ?? 0);
        $action_type = trim(antixss($_POST["action_type"] ?? ""));

        // Validate
        if ($user_id <= 0) {
            json_Msg("error", "Thiếu ID người dùng");
        }
        
        if ($amount <= 0) {
            json_Msg("error", "Số tiền phải lớn hơn 0");
        }
        
        if ($amount < 1000) {
            json_Msg("error", "Số tiền tối thiểu là 1,000đ");
        }
        
        if ($amount > 1000000000) {
            json_Msg("error", "Số tiền tối đa là 1,000,000,000đ");
        }
        
        if (!in_array($action_type, ["add", "subtract"])) {
            json_Msg("error", "Loại giao dịch không hợp lệ");
        }

        $check = $ketnoi->get_row("SELECT * FROM `users` WHERE `id` = '$user_id'");
        if (!$check) {
            json_Msg("error", "Người dùng không tồn tại");
        }

        $current_money = (int)$check['money'];
        $current_total_money = (int)$check['total_money'];

        if ($action_type == "subtract" && $amount > $current_money) {
            json_Msg("error", "Số dư không đủ để trừ " . money($amount) . "đ");
        }

        $ketnoi->begin_transaction();

        try {
            $now = time();

            if ($action_type == "add") {
                $update_money = $ketnoi->cong("users", "money", $amount, "`id` = '$user_id'");
                $update_total_money = $ketnoi->cong("users", "total_money", $amount, "`id` = '$user_id'");
                
                if (!$update_money || !$update_total_money) {
                    throw new Exception("Không thể cập nhật số dư");
                }
                
            } else {
                $update_money = $ketnoi->tru("users", "money", $amount, "`id` = '$user_id'");
                
                if (!$update_money) {
                    throw new Exception("Không thể trừ số dư");
                }
            }

            $update_time = $ketnoi->update("users", ["time" => $now], "`id` = '$user_id'");
            if (!$update_time) {
                throw new Exception("Không thể cập nhật thời gian");
            }
            
            $new_info = $ketnoi->get_row("SELECT `money`, `total_money`, `time` FROM `users` WHERE `id` = '$user_id'");
            
            $ketnoi->commit();
            
            exit(json_encode([
                "status" => "success",
                "msg" => "Điều chỉnh tiền thành công",
                "data" => [
                    "old_money" => $current_money,
                    "new_money" => $new_info['money'],
                    "old_total_money" => $current_total_money,
                    "new_total_money" => $new_info['total_money'],
                    "amount" => $amount,
                    "action" => $action_type,
                    "updated_time" => date('H:i:s d/m/Y', $new_info['time'])
                ]
            ]));
            
        } catch (Exception $e) {
            $ketnoi->rollback();
            json_Msg("error", $e->getMessage());
        }
    }
    // ===== HÀNH ĐỘNG KHÔNG HỢP LỆ =====
    else {
        json_Msg("error", "Hành động không hợp lệ");
    }
}

// ===== NẾU KHÔNG PHẢI POST REQUEST =====
json_Msg("error", "Phương thức không hợp lệ");
?>
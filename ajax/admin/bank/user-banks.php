<?php
require $_SERVER["DOCUMENT_ROOT"] . "/core/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    // ==================================================
    // 🟢 THÊM NGÂN HÀNG
    // ==================================================
    if ($action == "ADD_BANK") {
        $bank = trim(antixss($_POST["bank"] ?? ""));
        $accountNumber = trim(antixss($_POST["accountNumber"] ?? ""));
        $accountName = trim(antixss($_POST["accountName"] ?? ""));
        $status = trim(antixss($_POST["status"] ?? ""));
 
        // Kiểm tra đầu vào
        if ($bank === "" || $accountNumber === "" || $accountName === "") {
            json_Msg("error", "Vui lòng nhập đầy đủ thông tin ngân hàng");
        }

        if (!preg_match('/^[0-9]{6,20}$/', $accountNumber)) {
            json_Msg(
                "error",
                "Số tài khoản không hợp lệ (chỉ chứa số, 6–20 ký tự)"
            );
        }

        // Kiểm tra trùng số tài khoản
        $check = $ketnoi->get_row(
            "SELECT * FROM `bank` WHERE `bank` = '$bank' AND `accountNumber` = '$accountNumber'"
        );
        if ($check) {
            json_Msg(
                "error",
                "Tài khoản này đã tồn tại trong hệ thống (trùng ngân hàng và số tài khoản)"
            );
        }

        $ketnoi->begin_transaction();
        $insert = $ketnoi->insert("bank", array(
            "bank" => $bank,
            "accountNumber" => $accountNumber,
            "accountName" => $accountName,
            "status" => $status,
        ));

        if ($insert) {
            $ketnoi->commit();
            json_Msg("success", "Thêm ngân hàng thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Thêm ngân hàng thất bại");
        }
    }

    
    // ==================================================
    // 🟡 CẬP NHẬT TRẠNG THÁI NGÂN HÀNG
    // ==================================================
    elseif ($action == "UPDATE_BANK_STATUS") {
        $id = (int) ($_POST["id"] ?? 0);
        $status = trim(antixss($_POST["status"] ?? ""));

        if ($id <= 0) json_Msg("error", "Thiếu ID cần cập nhật");

        $check = $ketnoi->get_row("SELECT * FROM `bank` WHERE `id` = '$id'");
        if (!$check) json_Msg("error", "Ngân hàng không tồn tại");
        
        $ketnoi->begin_transaction();
        $update = $ketnoi->update("bank", array("status" => $status), "`id` = '$id'");
        if ($update) {
            $ketnoi->commit();
            json_Msg("success", "Cập nhật trạng thái thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Không thể cập nhật trạng thái");
        }
    }


    // ==================================================
    // 🟡 CẬP NHẬT NGÂN HÀNG
    // ==================================================
    elseif ($action == "UPDATE_BANK") {
        $id = (int) ($_POST["id"] ?? 0);
        $bank = trim(antixss($_POST["bank"] ?? ""));
        $accountNumber = trim(antixss($_POST["accountNumber"] ?? ""));
        $accountName = trim(antixss($_POST["accountName"] ?? ""));
        $status = trim(antixss($_POST["status"] ?? ""));

        if ($id <= 0) {
            json_Msg("error", "Thiếu ID ngân hàng");
        }
        if ($bank === "" || $accountNumber === "" || $accountName === "") {
            json_Msg("error", "Vui lòng nhập đầy đủ thông tin cập nhật");
        }

        $check = $ketnoi->get_row("SELECT * FROM `bank` WHERE `id` = '$id'");
        if (!$check) {
            json_Msg("error", "Ngân hàng không tồn tại");
        }

        $ketnoi->begin_transaction();
        $update = $ketnoi->update(
            "bank",
            [
                "bank" => $bank,
                "accountNumber" => $accountNumber,
                "accountName" => $accountName,
                "status" => $status,
            ],
            "`id` = '$id'"
        );

        if ($update) {
            $ketnoi->commit();
            json_Msg("success", "Cập nhật ngân hàng thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Cập nhật thất bại");
        }
    }

    // ==================================================
    // 🔴 XÓA NGÂN HÀNG
    // ==================================================
    elseif ($action == "DELETE_BANK") {
        $id = (int) ($_POST["id"] ?? 0);
        if ($id <= 0) {
            json_Msg("error", "Thiếu ID cần xóa");
        }

        $check = $ketnoi->get_row("SELECT * FROM `bank` WHERE `id` = '$id'");
        if (!$check) {
            json_Msg("error", "Ngân hàng không tồn tại");
        }

        $ketnoi->begin_transaction();
        $delete = $ketnoi->remove("bank", "`id` = '$id'");

        if ($delete) {
            $ketnoi->commit();
            json_Msg("success", "Đã xóa ngân hàng");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Xóa thất bại");
        }
    }

    // ==================================================
    // ⚠️ HÀNH ĐỘNG KHÔNG HỢP LỆ
    // ==================================================
    else {
        json_Msg("error", "Hành động không hợp lệ");
    }
}

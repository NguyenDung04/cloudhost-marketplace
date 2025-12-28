<?php
require $_SERVER["DOCUMENT_ROOT"] . "/core/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    // ==================================================
    // 🟢 THÊM GÓI HOSTING
    // ==================================================
    if ($action == "ADD_PACKAGE_HOSTING") {
        $name_host    = trim(antixss($_POST["name_host"] ?? ""));
        $server_host  = trim(antixss($_POST["server_host"] ?? ""));
        $money        = trim(antixss($_POST["money"] ?? ""));
        $disk         = trim(antixss($_POST["disk"] ?? ""));
        $other_domain = trim(antixss($_POST["other_domain"] ?? ""));
        $alias_domain = trim(antixss($_POST["alias_domain"] ?? ""));
        $status       = trim(antixss($_POST["status"] ?? "off")); 

        // ✅ Chuẩn hóa name_host và code_host
        $name_host_upper = strtoupper(str_replace(' ', '_', $name_host)); // VN_ALO
        $code_host = strtolower(str_replace(' ', '_', $name_host));       // vn_alo

        // Kiểm tra đầu vào
        if ($name_host_upper === "" || $server_host === "" || $money === "" || $disk === "") {
            json_Msg("error", "Vui lòng nhập đầy đủ thông tin gói hosting");
        }

        if (!is_numeric($money) || $money <= 0) {
            json_Msg("error", "Giá tiền không hợp lệ");
        }

        // Kiểm tra trùng code_host
        $check = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `code_host` = '$code_host'");
        if ($check) {
            json_Msg("error", "Tên gói này đã tồn tại trong hệ thống (code trùng)");
        }

        $ketnoi->begin_transaction();
        $insert = $ketnoi->insert("package_hosting", array(
            "name_host"    => $name_host_upper,
            "code_host"    => $code_host,
            "server_host"  => $server_host,
            "money"        => $money,
            "disk"         => $disk,
            "other_domain" => $other_domain,
            "alias_domain" => $alias_domain,
            "status"       => $status
        ));

        if ($insert) {
            $ketnoi->commit();
            json_Msg("success", "Thêm gói hosting thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Thêm gói hosting thất bại");
        }
    }

    // ==================================================
    // 🟣 CẬP NHẬT GÓI HOSTING
    // ==================================================
    elseif ($action == "UPDATE_PACKAGE_HOSTING") {
        $id           = (int)($_POST["id"] ?? 0);
        $name_host    = trim(antixss($_POST["name_host"] ?? ""));
        $server_host  = trim(antixss($_POST["server_host"] ?? ""));
        $money        = trim(antixss($_POST["money"] ?? ""));
        $disk         = trim(antixss($_POST["disk"] ?? ""));
        $other_domain = trim(antixss($_POST["other_domain"] ?? ""));
        $alias_domain = trim(antixss($_POST["alias_domain"] ?? ""));
        $status       = trim(antixss($_POST["status"] ?? "off"));

        if ($id <= 0) json_Msg("error", "Thiếu ID gói hosting"); 

        // ✅ Chuẩn hóa name_host và code_host
        $name_host_upper = strtoupper(str_replace(' ', '_', $name_host)); // VN_ALO
        $code_host = strtolower(str_replace(' ', '_', $name_host));       // vn_alo

        $check = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `id` = '$id'");
        if (!$check) json_Msg("error", "Gói hosting không tồn tại");

        $ketnoi->begin_transaction();
        $update = $ketnoi->update(
            "package_hosting",
            array(
                "name_host"    => $name_host_upper,
                "code_host"    => $code_host,
                "server_host"  => $server_host,
                "money"        => $money,
                "disk"         => $disk,
                "other_domain" => $other_domain,
                "alias_domain" => $alias_domain,
                "status"       => $status
            ),
            "`id` = '$id'"
        );

        if ($update) {
            $ketnoi->commit();
            json_Msg("success", "Cập nhật gói hosting thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Cập nhật thất bại");
        }
    }

    // ==================================================
    // 🟡 CẬP NHẬT TRẠNG THÁI GÓI HOSTING
    // ==================================================
    elseif ($action == "UPDATE_PACKAGE_HOSTING_STATUS") {
        $id     = (int)($_POST["id"] ?? 0);
        $status = trim(antixss($_POST["status"] ?? ""));

        if ($id <= 0) json_Msg("error", "Thiếu ID cần cập nhật");

        $check = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `id` = '$id'");
        if (!$check) json_Msg("error", "Gói hosting không tồn tại");

        $ketnoi->begin_transaction();
        $update = $ketnoi->update("package_hosting", array("status" => $status), "`id` = '$id'");
        if ($update) {
            $ketnoi->commit();
            json_Msg("success", "Cập nhật trạng thái thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Không thể cập nhật trạng thái");
        }
    }

    // ==================================================
    // 🔴 XÓA GÓI HOSTING
    // ==================================================
    elseif ($action == "DELETE_PACKAGE_HOSTING") {
        $id = (int)($_POST["id"] ?? 0);
        if ($id <= 0) json_Msg("error", "Thiếu ID cần xóa");

        $check = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `id` = '$id'");
        if (!$check) json_Msg("error", "Gói hosting không tồn tại");

        $ketnoi->begin_transaction();
        $delete = $ketnoi->remove("package_hosting", "`id` = '$id'");

        if ($delete) {
            $ketnoi->commit();
            json_Msg("success", "Đã xóa gói hosting thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Xóa gói hosting thất bại");
        }
    }

    // ==================================================
    // ⚠️ HÀNH ĐỘNG KHÔNG HỢP LỆ
    // ==================================================
    else {
        json_Msg("error", "Hành động không hợp lệ");
    }
}
?>

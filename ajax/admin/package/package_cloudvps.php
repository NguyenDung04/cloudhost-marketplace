<?php
require $_SERVER["DOCUMENT_ROOT"] . "/core/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    if ($action == "UPDATE_PCVPS_PRICE") {
        $id = (int) ($_POST["id"] ?? 0);
        $priceData = $_POST["price"] ?? "";

        if ($id <= 0) json_Msg("error", "Thiếu ID gói cần cập nhật");
        if ($priceData === "") json_Msg("error", "Thiếu dữ liệu giá cần cập nhật");

        $addon = $ketnoi->get_row("SELECT * FROM `package_cloudvps` WHERE `id` = '$id'");
        if (!$addon) json_Msg("error", "Gói không tồn tại");

        $oldPrice = json_decode($addon["price"], true);
        $newPrice = json_decode($priceData, true);
        if (!is_array($newPrice)) json_Msg("error", "Dữ liệu JSON không hợp lệ");

        // ✅ Cập nhật đúng cho cấu trúc 1 tầng
        foreach ($newPrice as $cycle => $data) {
            if (isset($oldPrice[$cycle])) {
                $oldPrice[$cycle]["amount"] = (int) $data["amount"];
            }
        }

        $priceJson = json_encode($oldPrice, JSON_UNESCAPED_UNICODE);

        $ketnoi->begin_transaction();
        $update = $ketnoi->update(
            "package_cloudvps",
            array(
                "price" => $priceJson,
                "updated_at" => time()
            ),
            "`id` = '$id'"
        );

        if ($update) {
            $ketnoi->commit();
            json_Msg("success", "Đã cập nhật giá addon thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Cập nhật giá thất bại");
        }
    } 
    
    // ==================================================
    // 🟡 CẬP NHẬT TRẠNG THÁI GÓI
    // ==================================================
    elseif ($action == "UPDATE_PCVPS_STATUS") {
        $id = (int) ($_POST["id"] ?? 0);
        $status = trim(antixss($_POST["status"] ?? ""));

        if ($id <= 0) json_Msg("error", "Thiếu ID cần cập nhật");

        $check = $ketnoi->get_row("SELECT * FROM `package_cloudvps` WHERE `id` = '$id'");
        if (!$check) json_Msg("error", "Gói không tồn tại");
        
        $ketnoi->begin_transaction();
        $update = $ketnoi->update("package_cloudvps", array("status" => $status), "`id` = '$id'");
        if ($update) {
            $ketnoi->commit();
            json_Msg("success", "Cập nhật trạng thái thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Không thể cập nhật trạng thái");
        }
    } else {
        json_Msg("error", "Hành động không hợp lệ");
    }
}

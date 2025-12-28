<?php
require $_SERVER["DOCUMENT_ROOT"] . "/core/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    if ($action == "UPDATE_ADDON_PRICE") {
        $id = (int) ($_POST["id"] ?? 0);
        $priceData = $_POST["price"] ?? "";

        if ($id <= 0) json_Msg("error", "Thiếu ID addon cần cập nhật");
        if ($priceData === "") json_Msg("error", "Thiếu dữ liệu giá cần cập nhật");

        $addon = $ketnoi->get_row("SELECT * FROM `addon_vps` WHERE `id` = '$id'");
        if (!$addon) json_Msg("error", "Addon không tồn tại");

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
            "addon_vps",
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
    } else {
        json_Msg("error", "Hành động không hợp lệ");
    }
}

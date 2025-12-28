<?php
require $_SERVER["DOCUMENT_ROOT"] . "/core/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    // ==================================================
    // 🟢 THÊM MÃ GIẢM GIÁ
    // ==================================================
    if ($action == "ADD_DISCOUNT") {

        $code       = trim(antixss($_POST["code"] ?? ""));
        $amount     = (int)trim(antixss($_POST["amount"] ?? "0"));
        $discount   = (float)trim(antixss($_POST["discount"] ?? "0"));
        $typeInput  = trim(antixss($_POST["type"] ?? "fixed"));
        $min        = (float)trim(antixss($_POST["min"] ?? "0"));
        $max        = (float)trim(antixss($_POST["max"] ?? "0"));
        $createdIn  = $_POST["createdate"] ?? "";
        $endIn      = $_POST["enddate"] ?? "";

        // Chuẩn hóa type
        $type = ($typeInput === "percent") ? "percent" : "fixed";

        // Validate cơ bản
        if ($code === "" || $amount <= 0) {
            json_Msg("error", "Vui lòng nhập đầy đủ mã giảm giá và số lượng hợp lệ");
        }

        if ($discount <= 0) {
            json_Msg("error", "Giá trị giảm không hợp lệ");
        }

        // Convert datetime-local -> timestamp
        $createdate = parseDatetimeToTimestamp($createdIn);
        if ($createdate == 0) {
            $createdate = time(); // mặc định = thời gian hiện tại
        }
        $enddate = parseDatetimeToTimestamp($endIn); // = 0 thì coi như không giới hạn

        $status = "on";     // thêm mới mặc định đang hoạt động
        $used   = 0;        // khi thêm mới luôn = 0

        // Kiểm tra trùng code
        $check = $ketnoi->get_row("SELECT * FROM `discount` WHERE `code` = '$code'");
        if ($check) {
            json_Msg("error", "Mã giảm giá này đã tồn tại trong hệ thống");
        }

        // Thêm mới
        $ketnoi->begin_transaction();
        $insert = $ketnoi->insert("discount", array(
            "code"      => $code,
            "amount"    => $amount,
            "used"      => $used,
            "discount"  => $discount,
            "type"      => $type,
            "min"       => $min,
            "max"       => $max,
            "createdate"=> $createdate,
            "enddate"   => $enddate,
            "status"    => $status
        ));

        if ($insert) {
            $ketnoi->commit();
            json_Msg("success", "Thêm mã giảm giá thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Thêm mã giảm giá thất bại");
        }
    }

    // ==================================================
    // 🟣 CẬP NHẬT MÃ GIẢM GIÁ
    // ==================================================
    elseif ($action == "UPDATE_DISCOUNT") {

        $id         = (int)($_POST["id"] ?? 0);
        $code       = trim(antixss($_POST["code"] ?? ""));
        $amount     = (int)trim(antixss($_POST["amount"] ?? "0"));
        $used       = (int)trim(antixss($_POST["used"] ?? "0"));
        $discount   = (float)trim(antixss($_POST["discount"] ?? "0"));
        $typeInput  = trim(antixss($_POST["type"] ?? "fixed"));
        $min        = (float)trim(antixss($_POST["min"] ?? "0"));
        $max        = (float)trim(antixss($_POST["max"] ?? "0"));
        $createdIn  = $_POST["createdate"] ?? "";
        $endIn      = $_POST["enddate"] ?? "";

        if ($id <= 0) {
            json_Msg("error", "Thiếu ID mã giảm giá");
        }

        // Chuẩn hóa type
        $type = ($typeInput === "percent") ? "percent" : "fixed";

        // Kiểm tra tồn tại
        $check = $ketnoi->get_row("SELECT * FROM `discount` WHERE `id` = '$id'");
        if (!$check) {
            json_Msg("error", "Mã giảm giá không tồn tại");
        }

        if ($code === "") {
            json_Msg("error", "Mã giảm giá không được để trống");
        }

        if ($amount < 0) {
            json_Msg("error", "Số lượng không hợp lệ");
        }

        if ($used < 0) {
            $used = 0;
        }

        if ($used > $amount) {
            json_Msg("error", "Số đã dùng không được lớn hơn số lượng");
        }

        if ($discount <= 0) {
            json_Msg("error", "Giá trị giảm không hợp lệ");
        }

        // Kiểm tra trùng code (không tính bản ghi hiện tại)
        $checkCode = $ketnoi->get_row("SELECT * FROM `discount` WHERE `code` = '$code' AND `id` != '$id'");
        if ($checkCode) {
            json_Msg("error", "Mã giảm giá này đã được sử dụng cho bản ghi khác");
        }

        // Convert datetime-local -> timestamp
        $createdate = parseDatetimeToTimestamp($createdIn);
        $enddate    = parseDatetimeToTimestamp($endIn);

        $ketnoi->begin_transaction();
        $update = $ketnoi->update(
            "discount",
            array(
                "code"      => $code,
                "amount"    => $amount,
                "used"      => $used,
                "discount"  => $discount,
                "type"      => $type,
                "min"       => $min,
                "max"       => $max,
                "createdate"=> $createdate,
                "enddate"   => $enddate
                // status không cho sửa ở đây, đã có action riêng
            ),
            "`id` = '$id'"
        );

        if ($update) {
            $ketnoi->commit();
            json_Msg("success", "Cập nhật mã giảm giá thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Cập nhật mã giảm giá thất bại");
        }
    }

    // ==================================================
    // 🟡 CẬP NHẬT TRẠNG THÁI MÃ GIẢM GIÁ
    // ==================================================
    elseif ($action == "UPDATE_DISCOUNT_STATUS") {

        $id     = (int)($_POST["id"] ?? 0);
        $status = trim(antixss($_POST["status"] ?? ""));

        if ($id <= 0) {
            json_Msg("error", "Thiếu ID cần cập nhật");
        }

        // Chuẩn hóa status
        $status = ($status === "on") ? "on" : "off";

        $check = $ketnoi->get_row("SELECT * FROM `discount` WHERE `id` = '$id'");
        if (!$check) {
            json_Msg("error", "Mã giảm giá không tồn tại");
        }

        $ketnoi->begin_transaction();
        $update = $ketnoi->update(
            "discount",
            array("status" => $status),
            "`id` = '$id'"
        );

        if ($update) {
            $ketnoi->commit();
            json_Msg("success", "Cập nhật trạng thái mã giảm giá thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Không thể cập nhật trạng thái mã giảm giá");
        }
    }

    // ==================================================
    // 🔴 XÓA MÃ GIẢM GIÁ
    // ==================================================
    elseif ($action == "DELETE_DISCOUNT") {

        $id = (int)($_POST["id"] ?? 0);
        if ($id <= 0) {
            json_Msg("error", "Thiếu ID cần xóa");
        }

        $check = $ketnoi->get_row("SELECT * FROM `discount` WHERE `id` = '$id'");
        if (!$check) {
            json_Msg("error", "Mã giảm giá không tồn tại");
        }

        $ketnoi->begin_transaction();
        $delete = $ketnoi->remove("discount", "`id` = '$id'");

        if ($delete) {
            $ketnoi->commit();
            json_Msg("success", "Đã xóa mã giảm giá thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Xóa mã giảm giá thất bại");
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

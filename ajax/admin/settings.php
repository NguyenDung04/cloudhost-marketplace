<?php
require $_SERVER["DOCUMENT_ROOT"] . "/core/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";  
    // ==================================================
    // 🟡 CẬP NHẬT CẤU HÌNH (1 dòng)
    // ==================================================
    if ($action == "UPDATE_OPTION") {
        $id    = (int) ($_POST["id"] ?? 0);
        $value = trim($_POST["value"] ?? "");

        if ($id <= 0) json_Msg("error", "Thiếu ID cấu hình cần cập nhật");

        $check = $ketnoi->get_row("SELECT * FROM `options` WHERE `id` = '$id'");
        if (!$check) json_Msg("error", "Cấu hình không tồn tại");

        $ketnoi->begin_transaction();
        $update = $ketnoi->update("options", ["value" => $value], "`id` = '$id'");
        if ($update) {
            $ketnoi->commit();
            json_Msg("success", "Cập nhật cấu hình thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Không thể cập nhật cấu hình");
        }
    }

    // ==================================================
    // 🟠 CẬP NHẬT NHIỀU CẤU HÌNH (từ FE form)
    // ==================================================
    elseif ($action == "UPDATE_OPTIONS") {
        $jsonData = $_POST["data"] ?? "";
        $data = json_decode($jsonData, true);

        if (!$data || !is_array($data)) json_Msg("error", "Dữ liệu không hợp lệ hoặc trống");

        $ketnoi->begin_transaction();
        $success = true;

        foreach ($data as $key => $value) {
            $key = trim(antixss($key));
            $value = trim($value);
            if ($key === "") continue;

            $check = $ketnoi->get_row("SELECT * FROM `options` WHERE `key` = '$key'");
            if ($check) {
                $update = $ketnoi->update("options", ["value" => $value], "`key` = '$key'");
                if (!$update) $success = false;
            } else {
                $insert = $ketnoi->insert("options", ["key" => $key, "value" => $value]);
                if (!$insert) $success = false;
            }
        }

        if ($success) {
            $ketnoi->commit();
            json_Msg("success", "Cập nhật cấu hình hệ thống thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Cập nhật thất bại, vui lòng thử lại");
        }
    }

    // ==================================================
    // 🟤 UPLOAD ẢNH CẤU HÌNH (favicon, logo, banner, ...)
    // ==================================================
    elseif ($action == "UPLOAD_OPTION_IMAGE") {
        $key = trim(antixss($_POST["key"] ?? ""));
        if ($key === "") json_Msg("error", "Thiếu key ảnh cần upload");

        if (!isset($_FILES["file"]) || $_FILES["file"]["error"] != 0) {
            json_Msg("error", "Không có tệp hợp lệ được gửi lên");
        }

        $file = $_FILES["file"];
        $ext  = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $allowed = ["jpg", "jpeg", "png", "gif", "webp"];

        if (!in_array($ext, $allowed)) {
            json_Msg("error", "Định dạng ảnh không hợp lệ (chỉ jpg, png, gif, webp)");
        }

        // 🗂 Tạo thư mục nếu chưa có
        $uploadDir = $_SERVER["DOCUMENT_ROOT"] . "/assets/images/options/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        // ✅ Đặt tên file chắc chắn có đuôi
        $fileName = time() . "_" . uniqid() . "." . $ext;
        $filePath = $uploadDir . $fileName;

        // 🔗 Đường dẫn tuyệt đối cho JS hiển thị
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
        $baseUrl .= "://" . $_SERVER['HTTP_HOST'];

        $fileUrl = $baseUrl . "/assets/images/options/" . $fileName;

        if (move_uploaded_file($file["tmp_name"], $filePath)) {
            // 🧩 Cập nhật DB
            $check = $ketnoi->get_row("SELECT * FROM `options` WHERE `key` = '$key'");
            if ($check) {
                $update = $ketnoi->update("options", ["value" => $fileUrl], "`key` = '$key'");
            } else {
                $update = $ketnoi->insert("options", ["key" => $key, "value" => $fileUrl]);
            }

            if ($update) {
                json_Msg("success", "Tải ảnh lên thành công", ["url" => $fileUrl]);
            } else {
                json_Msg("error", "Lưu URL ảnh thất bại trong cơ sở dữ liệu");
            }
        } else {
            json_Msg("error", "Không thể lưu ảnh lên máy chủ");
        }
    }


    // ==================================================
    // 🔴 XÓA CẤU HÌNH
    // ==================================================
    elseif ($action == "DELETE_OPTION") {
        $id = (int) ($_POST["id"] ?? 0);
        if ($id <= 0) json_Msg("error", "Thiếu ID cấu hình cần xóa");

        $check = $ketnoi->get_row("SELECT * FROM `options` WHERE `id` = '$id'");
        if (!$check) json_Msg("error", "Cấu hình không tồn tại");

        $ketnoi->begin_transaction();
        $delete = $ketnoi->remove("options", "`id` = '$id'");

        if ($delete) {
            $ketnoi->commit();
            json_Msg("success", "Đã xóa cấu hình thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Không thể xóa cấu hình");
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

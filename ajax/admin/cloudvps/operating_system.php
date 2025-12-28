<?php
require $_SERVER["DOCUMENT_ROOT"] . "/core/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    // ==================================================
    // 🟡 CẬP NHẬT HỆ ĐIỀU HÀNH
    // ==================================================
    if ($action == "UPDATE_OS") {
        $id = (int) ($_POST["id"] ?? 0);
        $os_name = trim(antixss($_POST["os_name"] ?? ""));

        if ($id <= 0) json_Msg("error", "Thiếu ID hệ điều hành");
        if ($os_name === "") json_Msg("error", "Vui lòng nhập tên hệ điều hành");

        // ✅ Lấy dữ liệu cũ
        $check = $ketnoi->get_row("SELECT * FROM `img_os` WHERE `id` = '$id'");
        if (!$check) json_Msg("error", "Hệ điều hành không tồn tại");

        // ==================================================
        // 🖼️ XỬ LÝ ẢNH UPLOAD
        // ==================================================
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/os_images/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $image_url = $check['image_url']; // mặc định giữ ảnh cũ

        // Nếu có upload ảnh mới
        if (isset($_FILES['os_image']) && $_FILES['os_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['os_image']['tmp_name'];
            $fileName = $_FILES['os_image']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            // Kiểm tra định dạng hợp lệ
            if (!in_array($fileExtension, $allowedExtensions)) {
                json_Msg("error", "Định dạng ảnh không hợp lệ (chỉ hỗ trợ JPG, PNG, GIF, WEBP)");
            }

            // Tạo tên file duy nhất
            $newFileName = 'os_' . time() . '_' . uniqid() . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;

            // Di chuyển file upload
            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                json_Msg("error", "Không thể lưu ảnh mới lên hệ thống");
            }

            // ✅ Xóa ảnh cũ (nếu có và tồn tại)
            if (!empty($check['image_url'])) {
                $oldPath = $_SERVER['DOCUMENT_ROOT'] . $check['image_url'];
                if (file_exists($oldPath)) unlink($oldPath);
            }

            // Lưu đường dẫn tương đối vào DB
            $image_url = '/assets/images/os_images/' . $newFileName;
        }

        // ==================================================
        // 💾 CẬP NHẬT DB
        // ==================================================
        $ketnoi->begin_transaction();
        $update = $ketnoi->update(
            "img_os",
            array(
                "os_name"    => $os_name,
                "image_url"  => $image_url,
                "updated_at" => time()
            ),
            "`id` = '$id'"
        );

        if ($update) {
            $ketnoi->commit();
            json_Msg("success", "Cập nhật hệ điều hành thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Cập nhật thất bại");
        }
    }

    // ==================================================
    // 🔴 XÓA HỆ ĐIỀU HÀNH
    // ==================================================
    elseif ($action == "DELETE_OS") {
        $id = (int) ($_POST["id"] ?? 0);
        if ($id <= 0) json_Msg("error", "Thiếu ID cần xóa");

        $check = $ketnoi->get_row("SELECT * FROM `img_os` WHERE `id` = '$id'");
        if (!$check) json_Msg("error", "Hệ điều hành không tồn tại");

        $ketnoi->begin_transaction();
        $delete = $ketnoi->remove("img_os", "`id` = '$id'");

        if ($delete) {
            // ✅ Xóa luôn ảnh vật lý (nếu có)
            if (!empty($check['image_url'])) {
                $oldPath = $_SERVER['DOCUMENT_ROOT'] . $check['image_url'];
                if (file_exists($oldPath)) unlink($oldPath);
            }

            $ketnoi->commit();
            json_Msg("success", "Đã xóa hệ điều hành thành công");
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
?>

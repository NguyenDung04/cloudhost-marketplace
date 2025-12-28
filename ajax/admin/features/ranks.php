<?php
require $_SERVER["DOCUMENT_ROOT"] . "/core/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    // Thư mục lưu ảnh rank
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/ranks/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // ==================================================
    // 🟢 THÊM HẠNG THÀNH VIÊN
    // ==================================================
    if ($action == "ADD_RANKS") {

        $name             = trim(antixss($_POST["name"] ?? ""));
        $description      = trim(antixss($_POST["description"] ?? ""));
        $discountPercent  = (float)trim(antixss($_POST["discount_percent"] ?? "0"));
        $siteconInput     = trim(antixss($_POST["sitecon"] ?? "off"));
        $minPoints        = (float)trim(antixss($_POST["min_points"] ?? "0"));
        $maxPoints        = (float)trim(antixss($_POST["max_points"] ?? "0"));
        $statusInput      = trim(antixss($_POST["status"] ?? "on"));

        // Chuẩn hóa on/off
        $sitecon = ($siteconInput === "on") ? "on" : "off";
        $status  = ($statusInput === "off") ? "off" : "on";

        if ($name === "") {
            json_Msg("error", "Vui lòng nhập tên hạng thành viên");
        }

        if ($minPoints < 0 || $maxPoints < 0) {
            json_Msg("error", "Min/Max điểm không hợp lệ");
        }

        if ($maxPoints > 0 && $maxPoints < $minPoints) {
            json_Msg("error", "Max điểm không được nhỏ hơn Min điểm");
        }

        if ($discountPercent < 0) {
            json_Msg("error", "Phần trăm giảm không hợp lệ");
        }

        // Kiểm tra trùng tên hạng
        $check = $ketnoi->get_row("SELECT * FROM `ranks` WHERE `name` = '$name'");
        if ($check) {
            json_Msg("error", "Tên hạng này đã tồn tại trong hệ thống");
        }

        // ================== XỬ LÝ ẢNH UPLOAD (TÙY CHỌN) ==================
        $imagePath = ""; // đường dẫn tương đối lưu trong DB

        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath  = $_FILES['image_file']['tmp_name'];
            $fileName     = $_FILES['image_file']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!in_array($fileExtension, $allowedExtensions)) {
                json_Msg("error", "Định dạng ảnh không hợp lệ (chỉ hỗ trợ JPG, PNG, GIF, WEBP)");
            }

            $newFileName = 'rank_' . time() . '_' . uniqid() . '.' . $fileExtension;
            $destPath    = $uploadDir . $newFileName;

            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                json_Msg("error", "Không thể lưu ảnh lên hệ thống");
            }

            // Lưu đường dẫn tương đối
            $imagePath = '/assets/images/ranks/' . $newFileName;
        }

        // Thời gian tạo
        $timeNow = time();

        $ketnoi->begin_transaction();
        $insert = $ketnoi->insert("ranks", array(
            "name"             => $name,
            "description"      => $description,
            "image"            => $imagePath,
            "min_points"       => $minPoints,
            "max_points"       => $maxPoints,
            "discount_percent" => $discountPercent,
            "sitecon"          => $sitecon,
            "status"           => $status,
            "time"             => $timeNow
        ));

        if ($insert) {
            $ketnoi->commit();
            json_Msg("success", "Thêm hạng thành viên thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Thêm hạng thành viên thất bại");
        }
    }

    // ==================================================
    // 🟣 CẬP NHẬT HẠNG THÀNH VIÊN
    // ==================================================
    elseif ($action == "UPDATE_RANKS") {

        $id               = (int)($_POST["id"] ?? 0);
        $name             = trim(antixss($_POST["name"] ?? ""));
        $description      = trim(antixss($_POST["description"] ?? ""));
        $discountPercent  = (float)trim(antixss($_POST["discount_percent"] ?? "0"));
        $siteconInput     = trim(antixss($_POST["sitecon"] ?? "off"));
        $minPoints        = (float)trim(antixss($_POST["min_points"] ?? "0"));
        $maxPoints        = (float)trim(antixss($_POST["max_points"] ?? "0"));
        $statusInput      = trim(antixss($_POST["status"] ?? "on"));
        $oldImage         = trim($_POST["old_image"] ?? "");

        if ($id <= 0) {
            json_Msg("error", "Thiếu ID hạng thành viên");
        }

        // Lấy dữ liệu cũ
        $check = $ketnoi->get_row("SELECT * FROM `ranks` WHERE `id` = '$id'");
        if (!$check) {
            json_Msg("error", "Hạng thành viên không tồn tại");
        }

        if ($name === "") {
            json_Msg("error", "Vui lòng nhập tên hạng thành viên");
        }

        if ($minPoints < 0 || $maxPoints < 0) {
            json_Msg("error", "Min/Max điểm không hợp lệ");
        }

        if ($maxPoints > 0 && $maxPoints < $minPoints) {
            json_Msg("error", "Max điểm không được nhỏ hơn Min điểm");
        }

        if ($discountPercent < 0) {
            json_Msg("error", "Phần trăm giảm không hợp lệ");
        }

        // Chuẩn hóa on/off
        $sitecon = ($siteconInput === "on") ? "on" : "off";
        $status  = ($statusInput === "off") ? "off" : "on";

        // Kiểm tra trùng tên (không tính bản ghi hiện tại)
        $checkName = $ketnoi->get_row("SELECT * FROM `ranks` WHERE `name` = '$name' AND `id` != '$id'");
        if ($checkName) {
            json_Msg("error", "Tên hạng này đã được sử dụng cho bản ghi khác");
        }

        // ================== XỬ LÝ ẢNH UPLOAD ==================
        $imagePath = $check['image']; // mặc định giữ ảnh cũ trong DB

        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath  = $_FILES['image_file']['tmp_name'];
            $fileName     = $_FILES['image_file']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!in_array($fileExtension, $allowedExtensions)) {
                json_Msg("error", "Định dạng ảnh không hợp lệ (chỉ hỗ trợ JPG, PNG, GIF, WEBP)");
            }

            $newFileName = 'rank_' . time() . '_' . uniqid() . '.' . $fileExtension;
            $destPath    = $uploadDir . $newFileName;

            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                json_Msg("error", "Không thể lưu ảnh mới lên hệ thống");
            }

            // Xóa ảnh cũ (nếu có)
            if (!empty($imagePath)) {
                $oldPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Lưu đường dẫn mới
            $imagePath = '/assets/images/ranks/' . $newFileName;
        }

        $ketnoi->begin_transaction();
        $update = $ketnoi->update(
            "ranks",
            array(
                "name"             => $name,
                "description"      => $description,
                "image"            => $imagePath,
                "min_points"       => $minPoints,
                "max_points"       => $maxPoints,
                "discount_percent" => $discountPercent,
                "sitecon"          => $sitecon,
                "status"           => $status
                // "time" giữ nguyên thời gian tạo, không cập nhật ở đây
            ),
            "`id` = '$id'"
        );

        if ($update) {
            $ketnoi->commit();
            json_Msg("success", "Cập nhật hạng thành viên thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Cập nhật hạng thành viên thất bại");
        }
    }

    // ==================================================
    // 🟡 CẬP NHẬT TRẠNG THÁI HẠNG THÀNH VIÊN
    // ==================================================
    elseif ($action == "UPDATE_RANKS_STATUS") {

        $id     = (int)($_POST["id"] ?? 0);
        $status = trim(antixss($_POST["status"] ?? ""));

        if ($id <= 0) {
            json_Msg("error", "Thiếu ID cần cập nhật");
        }

        $status = ($status === "on") ? "on" : "off";

        $check = $ketnoi->get_row("SELECT * FROM `ranks` WHERE `id` = '$id'");
        if (!$check) {
            json_Msg("error", "Hạng thành viên không tồn tại");
        }

        $ketnoi->begin_transaction();
        $update = $ketnoi->update(
            "ranks",
            array("status" => $status),
            "`id` = '$id'"
        );

        if ($update) {
            $ketnoi->commit();
            json_Msg("success", "Cập nhật trạng thái hạng thành viên thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Không thể cập nhật trạng thái hạng thành viên");
        }
    }

    // ==================================================
    // 🔴 XÓA HẠNG THÀNH VIÊN
    // ==================================================
    elseif ($action == "DELETE_RANKS") {

        $id = (int)($_POST["id"] ?? 0);
        if ($id <= 0) {
            json_Msg("error", "Thiếu ID cần xóa");
        }

        $check = $ketnoi->get_row("SELECT * FROM `ranks` WHERE `id` = '$id'");
        if (!$check) {
            json_Msg("error", "Hạng thành viên không tồn tại");
        }

        $ketnoi->begin_transaction();
        $delete = $ketnoi->remove("ranks", "`id` = '$id'");

        if ($delete) {
            // Xóa ảnh vật lý (nếu có)
            if (!empty($check['image'])) {
                $oldPath = $_SERVER['DOCUMENT_ROOT'] . $check['image'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $ketnoi->commit();
            json_Msg("success", "Đã xóa hạng thành viên thành công");
        } else {
            $ketnoi->rollback();
            json_Msg("error", "Xóa hạng thành viên thất bại");
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

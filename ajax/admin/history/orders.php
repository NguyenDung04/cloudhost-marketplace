<?php
require $_SERVER["DOCUMENT_ROOT"] . "/core/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$action = $_POST["action"] ?? ""; 

	// ==================================================
	// 🟡 CẬP NHẬT TRẠNG THÁI SERVER
	// ==================================================
	if ($action == "UPDATE_ORDER_STATUS") {
		$id = (int)($_POST["id"] ?? 0);
		$status = trim(antixss($_POST["status"] ?? ""));

		if ($id <= 0) json_Msg("error", "Thiếu ID cần cập nhật");

		$check = $ketnoi->get_row("SELECT * FROM `orders` WHERE `id` = '$id'");
		if (!$check) json_Msg("error", "Đơn hàng này không tồn tại không tồn tại");

		$ketnoi->begin_transaction();
		$update = $ketnoi->update("orders",array("status" => $status), "`id` = '$id'");

		if ($update) {
			$ketnoi->commit();
			json_Msg("success", "Cập nhật trạng thái thành công");
		} else {
			$ketnoi->rollback();
			json_Msg("error", "Không thể cập nhật trạng thái");
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

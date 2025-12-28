<?php
require $_SERVER["DOCUMENT_ROOT"] . "/core/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$action = $_POST["action"] ?? "";

	// ==================================================
	// 🟢 THÊM SERVER MỚI
	// ==================================================
	if ($action == "ADD_SERVER") {
		$name_server  = trim(antixss($_POST["name_server"] ?? "")); 
		$link_login_f   = trim(antixss($_POST["link_login"] ?? ""));
		$account_whm  = trim(antixss($_POST["account_whm"] ?? ""));
		$password_whm = trim(antixss($_POST["password_whm"] ?? ""));
		$ip_whm       = trim(antixss($_POST["ip_whm"] ?? ""));
		$name_server1 = trim(antixss($_POST["name_server1"] ?? ""));
		$name_server2 = trim(antixss($_POST["name_server2"] ?? ""));
		$status       = trim(antixss($_POST["status"] ?? "off"));

		// Kiểm tra đầu vào
		if ($name_server == "" || $link_login_f == "" || $account_whm == "" || $password_whm == "" || $ip_whm == "") {
			json_Msg("error", "Vui lòng nhập đầy đủ thông tin server");
		}

		// Kiểm tra trùng tên server
		$check = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `ip_whm` = '$ip_whm'");
		if ($check) {
			json_Msg("error", "IP này đã tồn tại trong hệ thống");
		}
 
		$link_login = "http://" . $link_login_f; 

		// Mã hóa thông tin nhạy cảm
		$account_whm_enc  = encryptData($account_whm);
		$password_whm_enc = encryptData($password_whm);
		$link_login_enc   = encryptData($link_login);
		$ip_whm_enc       = encryptData($ip_whm);
		$toSlug          = to_slug($name_server);

		$ketnoi->begin_transaction();
		$insert = $ketnoi->insert("server_hosting", array(
			"name_server"  => $name_server,
			"to_slug"      => $toSlug,
			"link_login"   => $link_login_enc,
			"account_whm"  => $account_whm_enc,
			"password_whm" => $password_whm_enc,
			"ip_whm"       => $ip_whm_enc,
			"name_server1" => $name_server1,
			"name_server2" => $name_server2,
			"status"       => $status
		));

		if ($insert) {
			$ketnoi->commit();
			json_Msg("success", "Thêm server thành công");
		} else {
			$ketnoi->rollback();
			json_Msg("error", "Thêm server thất bại");
		}
	}

	// ==================================================
	// 🟡 CẬP NHẬT TRẠNG THÁI SERVER
	// ==================================================
	elseif ($action == "UPDATE_STATUS") {
		$id = (int)($_POST["id"] ?? 0);
		$status = trim(antixss($_POST["status"] ?? ""));

		if ($id <= 0) json_Msg("error", "Thiếu ID cần cập nhật");

		$check = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$id'");
		if (!$check) json_Msg("error", "Server không tồn tại");

		$ketnoi->begin_transaction();
		$update = $ketnoi->update("server_hosting",array("status" => $status), "`id` = '$id'");

		if ($update) {
			$ketnoi->commit();
			json_Msg("success", "Cập nhật trạng thái thành công");
		} else {
			$ketnoi->rollback();
			json_Msg("error", "Không thể cập nhật trạng thái");
		}
	}

	// ==================================================
	// 🟣 CẬP NHẬT THÔNG TIN SERVER
	// ==================================================
	elseif ($action == "UPDATE_SERVER") {
		$id = (int)($_POST["id"] ?? 0);
		$name_server  = trim(antixss($_POST["name_server"] ?? ""));
 		$link_login_f   = trim(antixss($_POST["link_login"] ?? ""));
		$account_whm  = trim(antixss($_POST["account_whm"] ?? ""));
		$password_whm = trim(antixss($_POST["password_whm"] ?? ""));
		$ip_whm       = trim(antixss($_POST["ip_whm"] ?? ""));
		$name_server1 = trim(antixss($_POST["name_server1"] ?? ""));
		$name_server2 = trim(antixss($_POST["name_server2"] ?? ""));
		$status       = trim(antixss($_POST["status"] ?? ""));

		if ($id <= 0) json_Msg("error", "Thiếu ID server cần cập nhật");

		$check = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$id'");
		if (!$check) json_Msg("error", "Server không tồn tại");

		$link_login = "http://" . $link_login_f; 

		// Mã hóa lại các trường nhạy cảm
		$account_whm_enc  = encryptData($account_whm);
		$password_whm_enc = encryptData($password_whm);
		$link_login_enc   = encryptData($link_login);
		$ip_whm_enc       = encryptData($ip_whm);

		$toSlug = to_slug($name_server);

		$ketnoi->begin_transaction();
		$update = $ketnoi->update("server_hosting", array(
			"name_server"  => $name_server,
			"to_slug"      => $toSlug,
			"link_login"   => $link_login_enc,
			"account_whm"  => $account_whm_enc,
			"password_whm" => $password_whm_enc,
			"ip_whm"       => $ip_whm_enc,
			"name_server1" => $name_server1,
			"name_server2" => $name_server2,
			"status"       => $status
		), "`id` = '$id'");

		if ($update) {
			$ketnoi->commit();
			json_Msg("success", "Cập nhật thông tin server thành công");
		} else {
			$ketnoi->rollback();
			json_Msg("error", "Cập nhật thất bại");
		}
	}

	// ==================================================
	// 🔴 XÓA SERVER
	// ==================================================
	elseif ($action == "DELETE_SERVER") {
		$id = (int)($_POST["id"] ?? 0);
		if ($id <= 0) json_Msg("error", "Thiếu ID cần xóa");

		$check = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$id'");
		if (!$check) json_Msg("error", "Server không tồn tại");

		$ketnoi->begin_transaction();
		$delete = $ketnoi->remove("server_hosting", "`id` = '$id'");

		if ($delete) {
			$ketnoi->commit();
			json_Msg("success", "Đã xóa server thành công");
		} else {
			$ketnoi->rollback();
			json_Msg("error", "Xóa server thất bại");
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

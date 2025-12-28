<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Danh sách Server Hosting";
			?>
		<title><?php echo $title; ?></title>
		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
	</head>
	<body>
		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/nav.php';?>
		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/admin/sidebar.php';?>
		<div class="startbar-overlay d-print-none"></div>
		<div class="page-wrapper">
			<div class="page-content">
				<div class="container-fluid">
					<div class="row" bis_skin_checked="1">
						<div class="col-sm-12" bis_skin_checked="1">
							<div class="page-title-box d-md-flex justify-content-md-between align-items-center" bis_skin_checked="1">
								<h4 class="page-title"><?php echo $title; ?></h4>
							</div>
							<!--end page-title-box-->
						</div>
						<!--end col-->
					</div>
				</div>
				<?php
					// =============================
					// ⚙️ Phân trang + Sắp xếp
					// =============================
					$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
					$page  = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
					$offset = ($page - 1) * $limit;
					
					// Sắp xếp
					$sort = isset($_GET['sort']) && in_array($_GET['sort'], ['asc','desc']) ? $_GET['sort'] : 'asc';
					$orderBy = "ORDER BY `id` $sort";
					
					// Tổng số bản ghi
					$total_records = $ketnoi->num_rows("SELECT * FROM `server_hosting`");
					
					// Tổng số trang
					$total_pages = ceil($total_records / $limit);
					
					// Lấy dữ liệu theo trang + sắp xếp
					$rows = $ketnoi->get_list("SELECT * FROM `server_hosting` $orderBy LIMIT $offset, $limit");
					
					// Tính chỉ số hiển thị
					$from_record = $total_records > 0 ? $offset + 1 : 0;
					$to_record   = min($offset + $limit, $total_records);
				?>
				<div class="card">
					<!-- ================= HEADER ================= -->
					<div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
						<h4 class="card-title mb-0 text-uppercase fw-semibold">
							<i class="fas fa-server text-primary me-2"></i><?php echo $title; ?>
						</h4>
						<button class="btn btn-primary fw-semibold d-flex align-items-center gap-1" 
							data-bs-toggle="modal" 
							data-bs-target="#addServerModal">
						<i class="fas fa-plus-circle"></i> Thêm Server
						</button>
					</div>
					<!-- ================= FILTER ================= -->
					<div class="card-body">
						<form id="filterServerForm" class="row g-3 align-items-center flex-wrap justify-content-between">
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-hashtag text-primary"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterId" placeholder="Nhập ID server">
								</div>
							</div>
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-globe-asia text-success"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterServerName" placeholder="Nhập tên máy chủ">
								</div>
							</div>
							<div class="col-auto">
								<button type="reset" class="btn btn-danger px-4 py-2 fw-semibold" id="resetFilter">
								<i class="fas fa-trash-alt me-1"></i> Xóa lọc
								</button>
							</div>
						</form>
						<!-- ================== HIỂN THỊ PHẦN THÔNG TIN PHÂN TRANG + SẮP XẾP ================== -->
						<div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-3 border-top pt-3">
							<!-- BÊN TRÁI -->
							<div class="text-muted small order-2 order-md-1">
								<i class="far fa-list-alt me-1"></i>
								Showing <b><?= $from_record ?></b>–<b><?= $to_record ?></b>
								of <b><?= $total_records ?></b> records
							</div>
							<!-- BÊN PHẢI -->
							<div class="d-flex align-items-center flex-wrap justify-content-center justify-content-md-end gap-3 order-1 order-md-2">
								<div class="d-flex align-items-center gap-2">
									<span class="fw-semibold text-muted small">Hiển thị:</span>
									<select class="form-select form-select-sm w-auto" name="limit" id="limitSelect"
										onchange="window.location='?page=1&limit='+this.value+'&sort=<?= $sort ?>'">
										<option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
										<option value="25" <?= $limit == 25 ? 'selected' : '' ?>>25</option>
										<option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
										<option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100</option>
									</select>
								</div>
								<div class="d-flex align-items-center gap-2">
									<span class="fw-semibold text-muted small">Sắp xếp:</span>
									<select class="form-select form-select-sm w-auto" name="sort" id="sortSelect"
										onchange="window.location='?page=1&limit=<?= $limit ?>&sort='+this.value">
										<option value="asc" <?= $sort == 'asc' ? 'selected' : '' ?>>Cũ nhất</option>
										<option value="desc" <?= $sort == 'desc' ? 'selected' : '' ?>>Mới nhất</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<!-- ================= BẢNG DỮ LIỆU ================= -->
					<div class="card-body pt-0">
						<div class="table-responsive">
							<table class="table table-striped align-middle mb-0">
								<thead class="table-light text-uppercase text-secondary fw-semibold">
									<tr>
										<th><i class="fas fa-hashtag me-1 text-muted"></i>ID</th>
										<th><i class="fas fa-server me-1 text-primary"></i>Tên Server</th>
										<th><i class="fas fa-link me-1 text-success"></i>Đường dẫn WHM</th>
										<th><i class="fas fa-user-circle me-1 text-info"></i>Tài khoản</th>
										<th><i class="fas fa-key me-1 text-warning"></i>Mật khẩu</th>
										<th><i class="fas fa-network-wired me-1 text-primary"></i>IP</th>
										<th><i class="fas fa-sitemap me-1 text-success"></i>Nameserver</th>
										<th><i class="fas fa-toggle-on me-1 text-danger"></i>Trạng thái</th>
										<th class="text-center"><i class="fas fa-cogs me-1 text-secondary"></i>Hành động</th>
									</tr>
								</thead>
								<tbody id="serverTableBody">
									<?php if (!empty($rows)): ?>
									<?php foreach ($rows as $row): ?>
									<?php
										$link_login   = decodecryptData($row['link_login']);
										$account_whm  = decodecryptData($row['account_whm']);
										$password_whm = decodecryptData($row['password_whm']);
										$ip_whm       = decodecryptData($row['ip_whm']);
										?>
									<tr>
										<td><?= $row['id'] ?></td>
										<td class="fw-semibold text-primary"><?= ($row['name_server']) ?></td>
										<td>
											<a href="<?= ($row['link_login']) ?>" target="_blank" class="text-decoration-none">
											<i class="fas fa-external-link-alt me-1"></i><?= shortText($link_login) ?>
											</a>
										</td>
										<td>
											<div class="input-group input-group-sm">
												<input type="text" class="form-control border-0 bg-transparent p-0 text-primary fw-semibold copy-text"
													readonly value="<?= shortText($account_whm) ?>">
												<button class="btn btn-outline-secondary btn-sm btn-copy" type="button" title="Sao chép tài khoản">
												<i class="fas fa-copy	"></i>
												</button>
											</div>
										</td>
										<td>
											<div class="input-group input-group-sm">
												<input type="password" class="form-control border-0 bg-transparent p-0 text-muted copy-text"
													readonly value="<?= shortText($password_whm) ?>">
												<button class="btn btn-outline-secondary btn-sm btn-toggle-pass" type="button" title="Hiển thị mật khẩu">
												<i class="fas fa-eye-slash"></i>
												</button>
												<button class="btn btn-outline-secondary btn-sm btn-copy" type="button" title="Sao chép mật khẩu">
												<i class="fas fa-copy"></i>
												</button>
											</div>
										</td>
										<td><span class="badge rounded-pill bg-transparent border border-danger text-danger"><?= shortText($ip_whm) ?></span></td>
										<td>
											<small>
											<b><?= ($row['name_server1']) ?></b><br>
											<?= ($row['name_server2']) ?>
											</small>
										</td>
										<td>
											<div class="form-check form-switch d-inline-flex align-items-center justify-content-center">
												<input class="form-check-input toggle-status" type="checkbox" role="switch"
													data-id="<?= $row['id'] ?>" <?= $row['status'] == 'on' ? 'checked' : '' ?>>  
												</span>
											</div>
										</td>
										<td class="text-center"> 
											<button class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal"
												data-bs-target="#editServerModal_<?= $row['id'] ?>">
											<i class="fas fa-pen-to-square me-1"></i>Sửa
											</button>
											<button class="btn btn-outline-danger btn-sm btn-delete"
												data-id="<?= $row['id'] ?>"
												data-name="<?= ($row['name_server']) ?>">
											<i class="fas fa-trash-alt me-1"></i>Xóa
											</button>
										</td>
									</tr>
									<!-- 🧩 MODAL SỬA SERVER (ẩn cho từng dòng) -->
									<div class="modal fade" id="editServerModal_<?= $row['id'] ?>" tabindex="-1"
										aria-labelledby="editServerModalLabel_<?= $row['id'] ?>" aria-hidden="true">
										<div class="modal-dialog modal-lg modal-dialog-centered">
											<div class="modal-content border-0 shadow-lg rounded-3">
												<div class="modal-header bg-warning text-white">
													<h5 class="modal-title fw-semibold" id="editServerModalLabel_<?= $row['id'] ?>">
														<i class="fas fa-pen-to-square me-2"></i>Sửa Server #<?= $row['id'] ?>
													</h5>
													<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
												</div>
												<form class="editServerForm" data-id="<?= $row['id'] ?>" method="POST">
													<div class="modal-body p-4">
														<div class="row g-3">
															<div class="col-md-6">
																<label class="form-label fw-semibold">Tên Server</label>
																<input type="text" class="form-control" name="name_server"
																	value="<?= ($row['name_server']) ?>" required>
															</div>
															<div class="col-md-6">
																<label class="form-label fw-semibold">Đường dẫn WHM</label>
																<input type="text" class="form-control" name="link_login"
																	value="<?= ($link_login) ?>" required>
															</div>
															<div class="col-md-6">
																<label class="form-label fw-semibold">Tài khoản WHM</label>
																<input type="text" class="form-control" name="account_whm"
																	value="<?= ($account_whm) ?>" required>
															</div>
															<div class="col-md-6">
																<label class="form-label fw-semibold">Mật khẩu WHM</label>
																<input type="text" class="form-control" name="password_whm"
																	value="<?= ($password_whm) ?>" required>
															</div>
															<div class="col-md-6">
																<label class="form-label fw-semibold">IP WHM</label>
																<input type="text" class="form-control" name="ip_whm"
																	value="<?= ($ip_whm) ?>" required>
															</div>
															<div class="col-md-6">
																<label class="form-label fw-semibold">Trạng thái</label>
																<select class="form-select" name="status">
																	<option value="on"  <?= $row['status'] === 'on' ? 'selected' : '' ?>>Hoạt động</option>
																	<option value="off" <?= $row['status'] === 'off' ? 'selected' : '' ?>>Tạm tắt</option>
																</select>
															</div>
															<div class="col-md-6">
																<label class="form-label fw-semibold">Nameserver 1</label>
																<input type="text" class="form-control" name="name_server1"
																	value="<?= ($row['name_server1']) ?>">
															</div>
															<div class="col-md-6">
																<label class="form-label fw-semibold">Nameserver 2</label>
																<input type="text" class="form-control" name="name_server2"
																	value="<?= ($row['name_server2']) ?>">
															</div>
														</div>
													</div>
													<div class="modal-footer bg-light">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
														<i class="fas fa-times me-1"></i>Đóng
														</button>
														<button type="submit" class="btn btn-warning fw-semibold">
														<i class="fas fa-save me-1"></i>Cập nhật
														</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<?php endforeach; ?>
									<?php else: ?>
									<tr>
										<td colspan="9" class="text-center text-muted">Không có dữ liệu</td>
									</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- ================== PHẦN CHÂN (PHÂN TRANG) ================== -->
					<div class="card-footer bg-light border-top pt-3">
						<div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-3">
							<!-- Hiển thị thông tin số bản ghi -->
							<div class="order-2 order-md-1 text-muted small">
								Hiển thị <b><?= $from_record ?></b>–<b><?= $to_record ?></b> / <b><?= $total_records ?></b> bản ghi
							</div>
							<!-- Phân trang -->
							<nav class="order-1 order-md-2">
								<ul class="pagination pagination-sm mb-0 shadow-sm rounded overflow-hidden justify-content-center">
									<!-- ⏮ Trang đầu -->
									<li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
										<a class="page-link px-3 d-flex align-items-center gap-1"
											href="<?= ($page > 1) ? '?page=1&limit=' . $limit . '&sort=' . $sort : '#' ?>"
											data-action="first"
											<?= ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
										<i class="fas fa-angle-double-left"></i>
										<span class="d-none d-md-inline">Previous</span>
										</a>
									</li>
									<!-- ◀ Trang trước -->
									<li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
										<a class="page-link px-3"
											href="<?= ($page > 1) ? '?page=' . max(1, $page - 1) . '&limit=' . $limit . '&sort=' . $sort : '#' ?>"
											data-action="prev"
											<?= ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
										<i class="fas fa-angle-left"></i>
										</a>
									</li>
									<!-- 🔢 Số trang -->
									<?php for ($i = 1; $i <= $total_pages; $i++): ?>
									<li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
										<?php if ($i == $page): ?>
										<span class="page-link bg-primary text-white fw-semibold"><?= $i ?></span>
										<?php else: ?>
										<a class="page-link text-dark fw-semibold px-3"
											href="?page=<?= $i ?>&limit=<?= $limit ?>&sort=<?= $sort ?>"><?= $i ?></a>
										<?php endif; ?>
									</li>
									<?php endfor; ?>
									<!-- ▶ Trang sau -->
									<li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
										<a class="page-link px-3"
											href="<?= ($page < $total_pages) ? '?page=' . min($total_pages, $page + 1) . '&limit=' . $limit . '&sort=' . $sort : '#' ?>"
											data-action="next"
											<?= ($page >= $total_pages) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
										<i class="fas fa-angle-right"></i>
										</a>
									</li>
									<!-- ⏭ Trang cuối -->
									<li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
										<a class="page-link px-3 d-flex align-items-center gap-1"
											href="<?= ($page < $total_pages) ? '?page=' . $total_pages . '&limit=' . $limit . '&sort=' . $sort : '#' ?>"
											data-action="last"
											<?= ($page >= $total_pages) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
										<span class="d-none d-md-inline">Next</span>
										<i class="fas fa-angle-double-right"></i>
										</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
				<!-- ========== MODAL THÊM SERVER ========== -->
				<div class="modal fade" id="addServerModal" tabindex="-1" aria-labelledby="addServerModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered">
						<div class="modal-content border-0 shadow-lg rounded-3">
							<div class="modal-header bg-primary text-white">
								<h5 class="modal-title fw-semibold" id="addServerModalLabel">
									<i class="fas fa-server me-2"></i>Thêm Server Hosting mới
								</h5>
								<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
							</div>
							<form id="addServerForm" method="POST">
								<div class="modal-body p-4">
									<div class="row g-3">
										<div class="col-md-6">
											<label class="form-label fw-semibold">Tên Server</label>
											<input type="text" class="form-control" name="name_server" placeholder="Ví dụ: Việt Nam" required>
										</div>
										<div class="col-md-6">
											<label class="form-label fw-semibold">Đường dẫn WHM</label>
											<input type="text" class="form-control" name="link_login" placeholder="example.com:2087" required>
										</div>
										<div class="col-md-6">
											<label class="form-label fw-semibold">Tài khoản WHM</label>
											<input type="text" class="form-control" name="account_whm" placeholder="root" required>
										</div>
										<div class="col-md-6">
											<label class="form-label fw-semibold">Mật khẩu WHM</label>
											<input type="password" class="form-control" name="password_whm" placeholder="••••••••" required>
										</div>
										<div class="col-md-6">
											<label class="form-label fw-semibold">IP WHM</label>
											<input type="text" class="form-control" name="ip_whm" placeholder="103.99.xx.xx" required>
										</div>
										<div class="col-md-6">
											<label class="form-label fw-semibold">Trạng thái</label>
											<select class="form-select" name="status">
												<option value="on" selected>Hoạt động</option>
												<option value="off">Tạm tắt</option>
											</select>
										</div>
										<div class="col-md-6">
											<label class="form-label fw-semibold">Nameserver 1</label>
											<input type="text" class="form-control" name="name_server1" placeholder="ns1.example.com">
										</div>
										<div class="col-md-6">
											<label class="form-label fw-semibold">Nameserver 2</label>
											<input type="text" class="form-control" name="name_server2" placeholder="ns2.example.com">
										</div>
									</div>
								</div>
								<div class="modal-footer bg-light">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
									<i class="fas fa-times me-1"></i>Đóng
									</button>
									<button type="submit" class="btn btn-primary fw-semibold">
									<i class="fas fa-save me-1"></i>Lưu Server
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<script>
					"use strict";
					
					document.addEventListener("DOMContentLoaded", () => {
						const apiUrl = "/ajax/admin/cloudvps/server_hosting.php";
						// ==================================================
						// 🟢 THÊM SERVER (AJAX)
						// ==================================================
						document.getElementById("addServerForm")?.addEventListener("submit", async (e) => {
							e.preventDefault();
							const form = e.target;
							const fd = new FormData(form);
							fd.append("action", "ADD_SERVER");
					
							try {
								const res = await fetch(apiUrl, {
									method: "POST",
									body: fd
								});
								const data = await res.json();
					
								if (data.status === "success") {
									showAlert3("success", "Thành công", "Đã thêm server mới vào hệ thống!", 2000, () => location.reload());
									bootstrap.Modal.getInstance(document.getElementById("addServerModal"))?.hide();
								} else {
									showAlert3("error", "Thất bại", data.message || "Không thể thêm server!");
								}
							} catch {
								showAlert3("error", "Lỗi kết nối", "Không thể gửi dữ liệu lên máy chủ!");
							}
						});
					
					
						// ==================================================
						// 🟣 SỬA SERVER (AJAX)
						// ==================================================
						document.addEventListener("submit", async e => {
							const form = e.target.closest(".editServerForm");
							if (!form) return;
					
							e.preventDefault();
							const id = form.dataset.id;
							const fd = new FormData(form);
							fd.append("id", id);
							fd.append("action", "UPDATE_SERVER");
					
							try {
								const res = await fetch(apiUrl, {
									method: "POST",
									body: fd
								});
								const data = await res.json();
					
								if (data.status === "success") {
									showAlert3("success", "Thành công", data.message || "Cập nhật thành công!", 1500, () => location.reload());
									bootstrap.Modal.getInstance(form.closest(".modal"))?.hide();
								} else {
									showAlert3("error", "Lỗi", data.message || "Không thể cập nhật server!");
								}
							} catch {
								showAlert3("error", "Kết nối thất bại", "Không thể gửi yêu cầu lên máy chủ!");
							}
						});
					
					
						// ==================================================
						// 🟡 CẬP NHẬT TRẠNG THÁI (AJAX)
						// ==================================================
						document.addEventListener("change", async e => {
							const toggle = e.target.closest(".toggle-status");
							if (!toggle) return;
					
							const id = toggle.dataset.id;
							const newStatus = toggle.checked ? "on" : "off";
							toggle.disabled = true;
					
							try {
								const res = await fetch(apiUrl, {
									method: "POST",
									headers: { "Content-Type": "application/x-www-form-urlencoded" },
									body: new URLSearchParams({
										action: "UPDATE_STATUS",
										id,
										status: newStatus
									})
								});
								const data = await res.json();
					
								if (data.status === "success") {
									showAlert3("success", "Thành công", `Server #${id} đã ${newStatus === "on" ? "bật" : "tắt"}.`);
								} else {
									showAlert3("error", "Lỗi", data.message || "Không thể cập nhật trạng thái.");
									toggle.checked = !toggle.checked;
								}
							} catch {
								showAlert3("error", "Kết nối thất bại", "Không thể gửi yêu cầu lên máy chủ.");
								toggle.checked = !toggle.checked;
							} finally {
								toggle.disabled = false;
							}
						});
					
					
						// ==================================================
						// 🔴 XÓA SERVER (AJAX)
						// ==================================================
						document.addEventListener("click", e => {
							const btn = e.target.closest(".btn-delete");
							if (!btn) return;
					
							const id = btn.dataset.id;
							const name = btn.dataset.name || `#${id}`;
					
							Swal.fire({
								icon: "warning",
								title: "Xác nhận xóa?",
								html: `<div class="fw-semibold text-danger">Bạn có chắc muốn xóa server <b>${name}</b>?</div>
									<small class="text-muted">Hành động này không thể hoàn tác.</small>`,
								showCancelButton: true,
								confirmButtonText: "Xóa ngay",
								cancelButtonText: "Hủy",
								confirmButtonColor: "#dc3545",
								cancelButtonColor: "#6c757d",
								reverseButtons: true
							}).then(async result => {
								if (!result.isConfirmed) return;
					
								try {
									const res = await fetch(apiUrl, {
										method: "POST",
										headers: { "Content-Type": "application/x-www-form-urlencoded" },
										body: new URLSearchParams({
											action: "DELETE_SERVER",
											id
										})
									});
					
									const data = await res.json();
									if (data.status === "success") {
										showAlert3("success", "Thành công", data.message || `Đã xóa server ${name}!`, 1800, () => location.reload());
									} else {
										showAlert3("error", "Lỗi", data.message || "Không thể xóa server này!");
									}
								} catch {
									showAlert3("error", "Kết nối thất bại", "Không thể gửi yêu cầu lên máy chủ!");
								}
							});
						});
					
					
						// ==================================================
						// 📋 COPY TEXT & HIỂN THỊ MẬT KHẨU
						// ==================================================
						document.addEventListener("click", e => {
							const btnCopy = e.target.closest(".btn-copy");
							if (btnCopy) {
								const input = btnCopy.closest(".input-group").querySelector(".copy-text");
								navigator.clipboard.writeText(input.value).then(() => {
									btnCopy.innerHTML = '<i class="fas fa-check text-success"></i>';
									setTimeout(() => btnCopy.innerHTML = '<i class="fas fa-copy"></i>', 1000);
								});
							}
					
							const btnPass = e.target.closest(".btn-toggle-pass");
							if (btnPass) {
								const input = btnPass.closest(".input-group").querySelector("input");
								const icon = btnPass.querySelector("i");
								const isHidden = input.type === "password";
								input.type = isHidden ? "text" : "password";
								icon.classList.toggle("fa-eye");
								icon.classList.toggle("fa-eye-slash");
							}
						});
					
					
						// ==================================================
						// 🧭 PHÂN TRANG + LỌC CLIENT-SIDE
						// ==================================================
						const TOTAL_PAGES = <?= (int)$total_pages ?>;
						const CURRENT_PAGE = <?= (int)$page ?>;
						const tableBody = document.getElementById("serverTableBody");
						const originalRows = Array.from(tableBody.querySelectorAll("tr")).map(tr => tr.cloneNode(true));
					
						const filterEls = {
							id: document.getElementById("filterId"),
							name: document.getElementById("filterServerName"),
							reset: document.getElementById("resetFilter"),
							limit: document.getElementById("limitSelect"),
							sort: document.getElementById("sortSelect"),
						};
					
						function applyFilter() {
							const idVal = filterEls.id?.value.trim().toLowerCase() || "";
							const nameVal = filterEls.name?.value.trim().toLowerCase() || "";
					
							const filtered = originalRows.filter(tr => {
								const tds = tr.querySelectorAll("td");
								if (tds.length < 2) return false;
								const id = tds[0].innerText.toLowerCase();
								const name = tds[1].innerText.toLowerCase();
								return (!idVal || id.includes(idVal)) && (!nameVal || name.includes(nameVal));
							});
					
							tableBody.innerHTML = filtered.length
								? filtered.map(tr => tr.outerHTML).join("")
								: `<tr><td colspan="9" class="text-center text-muted">Không tìm thấy kết quả phù hợp</td></tr>`;
						}
					
						[filterEls.id, filterEls.name].forEach(el => {
							el?.addEventListener("input", applyFilter);
							el?.addEventListener("change", applyFilter);
						});
					
						filterEls.reset?.addEventListener("click", e => {
							e.preventDefault();
							filterEls.id.value = "";
							filterEls.name.value = "";
							if (filterEls.limit) filterEls.limit.value = "10";
							if (filterEls.sort) filterEls.sort.value = "asc";
							tableBody.innerHTML = originalRows.map(tr => tr.outerHTML).join("");
							window.location.href = window.location.origin + window.location.pathname;
						});
					
						// Phân trang
						function goToPage(newPage) {
							newPage = Math.max(1, Math.min(newPage, TOTAL_PAGES));
							const params = new URLSearchParams(window.location.search);
							params.set("page", newPage);
							params.set("limit", filterEls.limit?.value || 10);
							params.set("sort", filterEls.sort?.value || "asc");
							window.location.href = `${window.location.pathname}?${params.toString()}`;
						}
					
						document.querySelectorAll(".pagination .page-link").forEach(link => {
							link.addEventListener("click", e => {
								e.preventDefault();
								const li = link.closest(".page-item");
								if (li.classList.contains("disabled") || li.classList.contains("active")) return;
								let newPage = CURRENT_PAGE;
								switch (link.dataset.action) {
									case "first": newPage = 1; break;
									case "prev": newPage--; break;
									case "next": newPage++; break;
									case "last": newPage = TOTAL_PAGES; break;
									default:
										const num = parseInt(link.textContent.trim());
										if (!isNaN(num)) newPage = num;
								}
								goToPage(newPage);
							});
						});
					});
				</script>
				<?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
			</div>
		</div>
		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?> 
	</body>
</html>
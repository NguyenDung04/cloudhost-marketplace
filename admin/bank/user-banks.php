<!DOCTYPE html>
<html lang="vi" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Tài khoản ngân hàng người dùng";
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
							<div class="page-title-box d-md-flex justify-content-md-between align-items-center">
								<h4 class="page-title"><?php echo $title; ?></h4>
							</div>
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
						$total_records = $ketnoi->num_rows("SELECT * FROM `bank`");
						
						// Tổng số trang
						$total_pages = ceil($total_records / $limit);
						
						// Lấy dữ liệu theo trang + sắp xếp
						$rows = $ketnoi->get_list("SELECT * FROM `bank` $orderBy LIMIT $offset, $limit");
						
						// Tính chỉ số hiển thị
						$from_record = $total_records > 0 ? $offset + 1 : 0;
						$to_record   = min($offset + $limit, $total_records);
						?>
					<div class="card">
						<!-- ================= HEADER ================= -->
						<div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
							<h4 class="card-title mb-0 text-uppercase fw-semibold">
								<?php echo $title; ?>
							</h4>
							<button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addBankModal">
							<i class="fas fa-plus-circle me-2"></i> Thêm ngân hàng
							</button>
						</div>
						<!-- ================= FILTER FORM ================= -->
						<div class="card-body">
							<form id="filterBankForm" class="row g-3 align-items-center flex-wrap justify-content-between">
								<div class="col-auto flex-fill">
									<div class="input-group">
										<span class="input-group-text"><i class="fas fa-hashtag text-primary"></i></span>
										<input type="text" class="form-control py-2 fs-6" id="filterId" placeholder="ID Ngân hàng">
									</div>
								</div>
								<div class="col-auto flex-fill">
									<div class="input-group">
										<span class="input-group-text"><i class="fas fa-university text-success"></i></span>
										<input type="text" class="form-control py-2 fs-6" id="filterBank" placeholder="Tên ngân hàng">
									</div>
								</div>
								<div class="col-auto flex-fill">
									<div class="input-group">
										<span class="input-group-text"><i class="fas fa-credit-card text-warning"></i></span>
										<input type="text" class="form-control py-2 fs-6" id="filterAccountNumber" placeholder="Số tài khoản">
									</div>
								</div>
								<div class="col-auto flex-fill">
									<div class="input-group">
										<span class="input-group-text"><i class="fas fa-user text-dark"></i></span>
										<input type="text" class="form-control py-2 fs-6" id="filterAccountName" placeholder="Chủ tài khoản">
									</div>
								</div>
								<div class="col-auto flex-fill">
									<div class="input-group">
										<span class="input-group-text"><i class="fas fa-toggle-on text-info"></i></span>
										<select class="form-select py-2 fs-6" id="filterStatus">
											<option value="">Tất cả trạng thái</option>
											<option value="on">Hoạt động</option>
											<option value="off">Ẩn</option>
										</select>
									</div>
								</div>
								<div class="col-auto d-flex gap-2">
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
						<!-- ================= TABLE DATA ================= -->
						<div class="card-body pt-0">
							<div class="table-responsive">
								<table class="table table-striped mb-0">
									<thead class="table-light align-middle">
										<tr class="align-middle">
											<th><i class="fas fa-hashtag text-muted me-1"></i> ID</th>
											<th><i class="fas fa-university text-primary me-1"></i> TÊN NGÂN HÀNG</th>
											<th><i class="fas fa-credit-card text-success me-1"></i> SỐ TÀI KHOẢN</th>
											<th><i class="fas fa-user text-success me-1"></i> TÊN TÀI KHOẢN</th>
											<th class="text-center"><i class="fas fa-toggle-on text-info me-1"></i> TRẠNG THÁI</th>
											<th class="text-center"><i class="fas fa-cogs text-warning me-1"></i> HÀNH ĐỘNG</th>
										</tr>
									</thead>
									<!-- ================== BẢNG DỮ LIỆU ================== -->
									<tbody id="bankTableBody">
										<?php if (count($rows) > 0): ?>
										<?php foreach ($rows as $row): ?>
										<tr>
											<td><?= $row['id'] ?></td>
											<td class="fw-semibold text-primary"><?= ($row['bank']) ?></td>
											<td><?= ($row['accountNumber']) ?></td>
											<td><?= ($row['accountName']) ?></td>
											<td class="text-center">
												<div class="form-check form-switch d-flex justify-content-center">
													<input class="form-check-input toggle-status" type="checkbox" role="switch" 
														data-id="<?= $row['id'] ?>"
														<?= $row['status'] === 'on' ? 'checked' : '' ?>>
												</div>
											</td>
											<td class="text-center">
												<button class="btn btn-outline-primary btn-sm me-1 btn-edit" data-id="<?= $row['id'] ?>">
												<i class="fas fa-pen-to-square me-1"></i> Sửa
												</button>
												<button class="btn btn-outline-danger btn-sm btn-delete" data-id="<?= $row['id'] ?>">
												<i class="fas fa-trash-alt me-1"></i> Xóa
												</button>
											</td>
										</tr>
										<?php endforeach; ?>
										<?php else: ?>
										<tr>
											<td colspan="6" class="text-center text-muted">Không có dữ liệu</td>
										</tr>
										<?php endif; ?>
									</tbody>
								</table>
								<div id="tableLoading" 
									class="position-absolute top-50 start-50 translate-middle bg-light border rounded p-3 shadow text-secondary fw-semibold" 
									style="display:none; z-index:1050;">
									<div class="spinner-border text-primary me-2" role="status"></div>
									Đang tải dữ liệu...
								</div>
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
					<!-- ================= MODAL THÊM NGÂN HÀNG MỚI ================= -->
					<div class="modal fade" id="addBankModal" tabindex="-1" aria-labelledby="addBankLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered modal-lg">
							<div class="modal-content border-0 shadow-lg">
								<!-- Header -->
								<div class="modal-header bg-gradient-success text-white">
									<h5 class="modal-title fw-semibold" id="addBankLabel">
										<i class="fas fa-plus-circle me-2"></i>Thêm ngân hàng mới
									</h5>
									<button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
								</div>
								<!-- Form -->
								<form id="addBankForm" class="needs-validation" novalidate>
									<div class="modal-body bg-light-subtle py-4">
										<div class="card border-0 shadow-sm">
											<div class="card-body p-0">
												<table class="table mb-0 align-middle">
													<tbody>
														<tr>
															<th class="w-30 bg-light fw-semibold text-secondary ps-3">
																<i class="fas fa-university me-2 text-success"></i>Tên ngân hàng
															</th>
															<td class="p-3">
																<input type="text" name="bank" class="form-control form-control-lg" placeholder="" required>
															</td>
														</tr>
														<tr>
															<th class="bg-light fw-semibold text-secondary ps-3">
																<i class="fas fa-credit-card me-2 text-warning"></i>Số tài khoản
															</th>
															<td class="p-3">
																<input type="text" name="accountNumber" class="form-control form-control-lg" placeholder="" pattern="[0-9]{6,20}" required>
															</td>
														</tr>
														<tr>
															<th class="bg-light fw-semibold text-secondary ps-3">
																<i class="fas fa-user me-2 text-primary"></i>Chủ tài khoản
															</th>
															<td class="p-3">
																<input type="text" name="accountName" class="form-control form-control-lg" placeholder="" required>
															</td>
														</tr>
														<tr>
															<th class="bg-light fw-semibold text-secondary ps-3">
																<i class="fas fa-toggle-on me-2 text-info"></i>Trạng thái
															</th>
															<td class="p-3">
																<select class="form-select form-select-lg" name="status" required>
																	<option value="on" selected>Hoạt động</option>
																	<option value="off">Ẩn</option>
																</select>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<!-- Footer -->
									<div class="modal-footer bg-light-subtle border-0">
										<button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
										<i class="fas fa-times me-1"></i>Đóng
										</button>
										<button type="submit" class="btn btn-success px-4 shadow-sm">
										<i class="fas fa-save me-1"></i>Lưu ngân hàng
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- ================= MODAL SỬA NGÂN HÀNG ================= -->
					<div class="modal fade" id="editBankModal" tabindex="-1" aria-labelledby="editBankLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered modal-lg">
							<div class="modal-content border-0 shadow-lg">
								<!-- Header -->
								<div class="modal-header bg-primary text-white">
									<h5 class="modal-title fw-semibold" id="editBankLabel">
										<i class="fas fa-pen-to-square me-2"></i> Sửa thông tin ngân hàng
									</h5>
									<button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
								</div>
								<!-- Form -->
								<form id="editBankForm" class="needs-validation" novalidate>
									<div class="modal-body bg-light-subtle py-4">
										<input type="hidden" name="id" id="editBankId">
										<div class="card border-0 shadow-sm">
											<div class="card-body p-0">
												<table class="table mb-0 align-middle">
													<tbody>
														<tr>
															<th class="w-30 bg-light fw-semibold text-secondary ps-3">
																<i class="fas fa-university me-2 text-success"></i>Tên ngân hàng
															</th>
															<td class="p-3">
																<input type="text" name="bank" id="editBankName" class="form-control form-control-lg" required>
															</td>
														</tr>
														<tr>
															<th class="bg-light fw-semibold text-secondary ps-3">
																<i class="fas fa-credit-card me-2 text-warning"></i>Số tài khoản
															</th>
															<td class="p-3">
																<input type="text" name="accountNumber" id="editAccountNumber" class="form-control form-control-lg" pattern="[0-9]{6,20}" required>
															</td>
														</tr>
														<tr>
															<th class="bg-light fw-semibold text-secondary ps-3">
																<i class="fas fa-user me-2 text-primary"></i>Chủ tài khoản
															</th>
															<td class="p-3">
																<input type="text" name="accountName" id="editAccountName" class="form-control form-control-lg" required>
															</td>
														</tr>
														<tr>
															<th class="bg-light fw-semibold text-secondary ps-3">
																<i class="fas fa-toggle-on me-2 text-info"></i>Trạng thái
															</th>
															<td class="p-3">
																<select class="form-select form-select-lg" name="status" id="editStatus" required>
																	<option value="on">Hoạt động</option>
																	<option value="off">Ẩn</option>
																</select>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<!-- Footer -->
									<div class="modal-footer bg-light-subtle border-0">
										<button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
										<i class="fas fa-times me-1"></i>Đóng
										</button>
										<button type="submit" class="btn btn-primary px-4 shadow-sm">
										<i class="fas fa-save me-1"></i>Cập nhật
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<script>
						"use strict";
						document.addEventListener("DOMContentLoaded", () => {
							// ============================
							// 🔧 CẤU HÌNH CƠ BẢN
							// ============================
							const apiUrl = "/ajax/admin/bank/user-banks.php";
							const TOTAL_PAGES = <?= (int)$total_pages ?>;
							const CURRENT_PAGE = <?= (int)$page ?>;
							const paginationLinks = document.querySelectorAll(".pagination .page-link");
							const tableBody = document.getElementById("bankTableBody");
							const originalRows = Array.from(tableBody.querySelectorAll("tr")).map(tr => tr.cloneNode(true));
							
							// ============================
							// 🎨 HIỆU ỨNG PHÂN TRANG
							// ============================
							paginationLinks.forEach(link => {
								const li = link.closest(".page-item");
								const isDisabled = li.classList.contains("disabled");
								const isActive = li.classList.contains("active");
							
								if (isDisabled) {
								Object.assign(link.style, {
									pointerEvents: "none",
									cursor: "not-allowed",
									opacity: "0.5",
									userSelect: "none",
								});
								link.setAttribute("tabindex", "-1");
								link.setAttribute("aria-disabled", "true");
								link.addEventListener("focus", e => e.target.blur());
								} else if (isActive) {
								Object.assign(link.style, {
									backgroundColor: "#4f6ef7",
									color: "#fff",
									fontWeight: "600",
									boxShadow: "0 0 6px rgba(79,110,247,0.4)",
									userSelect: "none",
								});
								} else {
								link.addEventListener("mouseenter", () => {
									link.style.backgroundColor = "#0d6efd";
									link.style.color = "#fff";
									link.style.transition = "0.2s";
								});
								link.addEventListener("mouseleave", () => {
									link.style.backgroundColor = "";
									link.style.color = "";
								});
								}
							});
							
							// ============================
							// 🎯 FOCUS ICON INPUT
							// ============================
							document.querySelectorAll(".input-group").forEach(group => {
								const icon = group.querySelector(".input-group-text");
								const input = group.querySelector("input, select");
								if (icon && input) {
								icon.addEventListener("click", () => input.focus());
								icon.style.cursor = "pointer";
								}
							});
							
							// ============================
							// 🔍 LỌC DỮ LIỆU CLIENT-SIDE
							// ============================
							const filterEls = {
								id: document.getElementById("filterId"),
								bank: document.getElementById("filterBank"),
								accNum: document.getElementById("filterAccountNumber"),
								accName: document.getElementById("filterAccountName"),
								status: document.getElementById("filterStatus"),
								reset: document.getElementById("resetFilter"),
								limit: document.getElementById("limitSelect"),
								sort: document.getElementById("sortSelect"),
							};
							
							function applyFilter() {
								const idVal = filterEls.id.value.trim().toLowerCase();
								const bankVal = filterEls.bank.value.trim().toLowerCase();
								const accNumVal = filterEls.accNum.value.trim().toLowerCase();
								const accNameVal = filterEls.accName.value.trim().toLowerCase();
								const statusVal = filterEls.status.value.trim();
							
								const filtered = originalRows.filter(tr => {
								const tds = tr.querySelectorAll("td");
								if (tds.length < 5) return false;
								const id = tds[0].innerText.toLowerCase();
								const bank = tds[1].innerText.toLowerCase();
								const accNum = tds[2].innerText.toLowerCase();
								const accName = tds[3].innerText.toLowerCase();
								const status = tr.querySelector(".toggle-status")?.checked ? "on" : "off";
							
								return (
									(!idVal || id.includes(idVal)) &&
									(!bankVal || bank.includes(bankVal)) &&
									(!accNumVal || accNum.includes(accNumVal)) &&
									(!accNameVal || accName.includes(accNameVal)) &&
									(!statusVal || status === statusVal)
								);
								});
							
								tableBody.innerHTML = filtered.length
								? filtered.map(tr => tr.outerHTML).join("")
								: `<tr><td colspan="6" class="text-center text-muted">Không tìm thấy kết quả phù hợp</td></tr>`;
							}
							
							Object.values(filterEls).forEach(el => {
								if (el && ["INPUT", "SELECT"].includes(el.tagName))
								el.addEventListener("input", applyFilter);
							});
							
							filterEls.reset?.addEventListener("click", e => {
								e.preventDefault();
								Object.keys(filterEls).forEach(key => {
								if (["id", "bank", "accNum", "accName", "status"].includes(key))
									filterEls[key].value = "";
								});
								if (filterEls.limit) filterEls.limit.value = "10";
								if (filterEls.sort) filterEls.sort.value = "asc";
								tableBody.innerHTML = originalRows.map(tr => tr.outerHTML).join("");
								window.location.href = window.location.origin + window.location.pathname;
							});
							
							// ============================
							// ⏩ PHÂN TRANG
							// ============================
							function goToPage(newPage) {
								newPage = Math.max(1, Math.min(newPage, TOTAL_PAGES));
								const params = new URLSearchParams(window.location.search);
								params.set("page", newPage);
								params.set("limit", filterEls.limit.value);
								params.set("sort", filterEls.sort.value);
								window.location.href = `${window.location.pathname}?${params.toString()}`;
							}
							
							paginationLinks.forEach(link => {
								link.addEventListener("click", e => {
								e.preventDefault();
								const li = link.closest(".page-item");
								if (li.classList.contains("disabled") || li.classList.contains("active")) return;
								const action = link.dataset.action;
								let newPage = CURRENT_PAGE;
								switch (action) {
									case "first":
									newPage = 1;
									break;
									case "prev":
									newPage--;
									break;
									case "next":
									newPage++;
									break;
									case "last":
									newPage = TOTAL_PAGES;
									break;
									default:
									const num = parseInt(link.textContent.trim());
									if (!isNaN(num)) newPage = num;
								}
								goToPage(newPage);
								});
							});
							
							// ============================
							// 🟢 THÊM NGÂN HÀNG (AJAX)
							// ============================
							const addBankForm = document.getElementById("addBankForm");
							addBankForm?.addEventListener("submit", e => {
								e.preventDefault();
								const formData = new FormData(addBankForm);
								formData.append("action", "ADD_BANK");
								Swal.fire({ title: "Đang xử lý...", icon: "info", showConfirmButton: false, didOpen: () => Swal.showLoading() });
								fetch(apiUrl, { method: "POST", body: formData })
								.then(res => res.json())
								.then(data => {
									Swal.close();
									if (data.status === "success")
									showAlert3("success", "Thành công!", data.msg, 2500, () => {
										bootstrap.Modal.getInstance(document.getElementById("addBankModal"))?.hide();
										addBankForm.reset();
										window.location.reload();
									});
									else showAlert3("error", "Lỗi!", data.msg || "Không thể thêm ngân hàng.", 3000);
								})
								.catch(() => {
									Swal.close();
									showAlert3("error", "Lỗi kết nối!", "Không thể kết nối tới máy chủ.", 3000);
								});
							});
							
							// ============================
							// ✏️ CẬP NHẬT NGÂN HÀNG
							// ============================
							document.querySelectorAll(".btn-edit").forEach(btn => {
								btn.addEventListener("click", () => {
								const row = btn.closest("tr");
								if (!row) return;
								const id = btn.dataset.id;
								document.getElementById("editBankId").value = id;
								document.getElementById("editBankName").value = row.children[1].innerText.trim();
								document.getElementById("editAccountNumber").value = row.children[2].innerText.trim();
								document.getElementById("editAccountName").value = row.children[3].innerText.trim();
								document.getElementById("editStatus").value = row.querySelector(".toggle-status")?.checked ? "on" : "off";
								new bootstrap.Modal(document.getElementById("editBankModal")).show();
								});
							});
							
							const editForm = document.getElementById("editBankForm");
							editForm?.addEventListener("submit", e => {
								e.preventDefault();
								const formData = new FormData(editForm);
								formData.append("action", "UPDATE_BANK");
								Swal.fire({ title: "Đang cập nhật...", icon: "info", showConfirmButton: false, didOpen: () => Swal.showLoading() });
								fetch(apiUrl, { method: "POST", body: formData })
								.then(res => res.json())
								.then(data => {
									Swal.close();
									if (data.status === "success")
									showAlert3("success", "Thành công!", data.msg, 2500, () => {
										bootstrap.Modal.getInstance(document.getElementById("editBankModal"))?.hide();
										window.location.reload();
									});
									else showAlert3("error", "Lỗi!", data.msg || "Cập nhật thất bại.", 3000);
								})
								.catch(() => {
									Swal.close();
									showAlert3("error", "Lỗi kết nối!", "Không thể kết nối tới máy chủ.", 3000);
								});
							});
							
							// ============================
							// 🔁 CẬP NHẬT TRẠNG THÁI (KHÔNG RELOAD)
							// ============================
							document.querySelectorAll(".toggle-status").forEach(toggle => {
								toggle.addEventListener("change", function () {
								const id = this.dataset.id;
								const newStatus = this.checked ? "on" : "off";
								this.disabled = true;
								const formData = new FormData();
								formData.append("action", "UPDATE_BANK_STATUS");
								formData.append("id", id);
								formData.append("status", newStatus);
							
								fetch(apiUrl, { method: "POST", body: formData })
									.then(res => res.json())
									.then(data => {
									this.disabled = false;
									if (data.status === "success") showAlert3("success", "Thành công!", data.msg, 2000);
									else {
										this.checked = !this.checked;
										showAlert3("error", "Lỗi!", data.msg || "Không thể cập nhật.", 3000);
									}
									})
									.catch(() => {
									this.disabled = false;
									this.checked = !this.checked;
									showAlert3("error", "Lỗi kết nối!", "Không thể kết nối tới máy chủ.", 3000);
									});
								});
							});
							
							// ============================
							// 🔴 XÓA NGÂN HÀNG
							// ============================
							document.querySelectorAll(".btn-delete").forEach(btn => {
								btn.addEventListener("click", () => {
								const id = btn.dataset.id;
								if (!id) return;
								Swal.fire({
									title: "Xác nhận xóa",
									html: "<div class='fw-semibold'>Bạn có chắc muốn xóa ngân hàng này không?</div>",
									icon: "warning",
									showCancelButton: true,
									confirmButtonText: "Đồng ý",
									cancelButtonText: "Hủy",
									confirmButtonColor: "#d33",
									cancelButtonColor: "#6c757d",
									reverseButtons: true,
								}).then(result => {
									if (!result.isConfirmed) return;
									Swal.fire({ title: "Đang xóa...", icon: "info", showConfirmButton: false, didOpen: () => Swal.showLoading() });
									const formData = new FormData();
									formData.append("action", "DELETE_BANK");
									formData.append("id", id);
									fetch(apiUrl, { method: "POST", body: formData })
									.then(res => res.json())
									.then(data => {
										Swal.close();
										if (data.status === "success")
										showAlert3("success", "Thành công!", data.msg, 2000, () => btn.closest("tr")?.remove());
										else showAlert3("error", "Lỗi!", data.msg || "Xóa thất bại.", 3000);
									})
									.catch(() => {
										Swal.close();
										showAlert3("error", "Lỗi kết nối!", "Không thể kết nối tới máy chủ.", 3000);
									});
								});
								});
							});
						});
					</script>
					<?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
				</div>
			</div>
		</div>
		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?> 
	</body>
</html>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Mã giảm giá & Khuyến mãi";
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
                            </div><!--end page-title-box-->
                        </div><!--end col-->
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
					$total_records = $ketnoi->num_rows("SELECT * FROM `discount`");
					
					// Tổng số trang
					$total_pages = ceil($total_records / $limit);
					
					// Lấy dữ liệu theo trang + sắp xếp
					$rows = $ketnoi->get_list("SELECT * FROM `discount` $orderBy LIMIT $offset, $limit");
					
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
								data-bs-target="#addDiscountModal">
							<i class="fas fa-plus-circle"></i> Thêm mã giảm giá
						</button>

					</div>
					<!-- ================= FILTER ================= -->
					<div class="card-body">
						<form id="filterDiscountForm" class="row g-3 align-items-center flex-wrap justify-content-between">
							<!-- Tìm theo ID / Mã code -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text">
										<i class="fas fa-ticket-alt text-primary"></i>
									</span>
									<input type="text"
										class="form-control py-2 fs-6"
										id="filterCode"
										placeholder="Nhập ID hoặc mã giảm giá">
								</div>
							</div>

							<!-- Lọc theo loại giảm giá -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text">
										<i class="fas fa-percent text-success"></i>
									</span>
									<select class="form-select py-2 fs-6" id="filterType">
										<option value="">Tất cả loại</option>
										<option value="fixed">Giảm cố định</option>
										<option value="percent">Giảm phần trăm</option>
									</select>
								</div>
							</div>

							<!-- Nút reset -->
							<div class="col-auto">
								<button type="reset" class="btn btn-danger px-4 py-2 fw-semibold" id="resetFilterDiscount">
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
					<!-- ================= BẢNG MÃ GIẢM GIÁ ================= -->
					<div class="card-body pt-0">
						<div class="table-responsive">
							<table class="table table-striped align-middle mb-0">
								<thead class="table-light text-uppercase text-secondary fw-semibold">
									<tr>
										<th><i class="fas fa-hashtag me-1 text-muted"></i>ID</th>
										<th><i class="fas fa-ticket-alt me-1 text-primary"></i>Mã code</th>
										<th><i class="fas fa-boxes-stacked me-1 text-success"></i>Số lượng</th>
										<th><i class="fas fa-check-circle me-1 text-info"></i>Đã dùng</th>
										<th><i class="fas fa-percent me-1 text-warning"></i>Giảm</th>
										<th><i class="fas fa-calendar-plus me-1 text-primary"></i>Ngày tạo</th>
										<th><i class="fas fa-calendar-times me-1 text-danger"></i>Ngày hết hạn</th>
										<th><i class="fas fa-money-bill-wave me-1 text-success"></i>Min</th>
										<th><i class="fas fa-money-check-alt me-1 text-success"></i>Max</th>
										<th><i class="fas fa-tag me-1 text-secondary"></i>Loại</th>
										<th><i class="fas fa-tag me-1 text-secondary"></i>Trạng thái</th>
										<th class="text-center"><i class="fas fa-cogs me-1 text-secondary"></i>Hành động</th>
									</tr>
								</thead>
								<tbody id="discountTableBody">
									<?php if (!empty($rows)): ?>
										<?php foreach ($rows as $row): ?>
											<tr data-type="<?= $row['type'] ?>">
												<td><?= $row['id'] ?></td>

												<td class="fw-semibold text-primary">
													<?= ($row['code']) ?>
												</td>

												<td><?= money($row['amount']) ?></td>
												<td><?= (int)$row['used'] ?></td>

												<td>
													<?php if ($row['type'] === 'percent'): ?>
														<?= (float)$row['discount'] ?>%
													<?php else: ?>
														<?= money($row['discount']) ?>
													<?php endif; ?>
												</td>

												<td><?= date("d/m/Y H:i", $row['createdate']) ?></td>
												<td><?= date("d/m/Y H:i", $row['enddate']) ?></td>

												<td><?= money($row['min']) ?></td>
												<td><?= money($row['max']) ?></td>

												<td>
													<span class="badge rounded-pill 
														<?= $row['type'] === 'percent' ? 'bg-info-subtle text-info' : 'bg-warning-subtle text-warning' ?>">
														<?= $row['type'] === 'percent' ? 'Phần trăm' : 'Cố định' ?>
													</span>
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
															data-bs-target="#editDiscountModal_<?= $row['id'] ?>">
														<i class="fas fa-pen-to-square me-1"></i>Sửa
													</button>
													<button class="btn btn-outline-danger btn-sm btn-delete-discount"
															data-id="<?= $row['id'] ?>"
															data-code="<?= ($row['code']) ?>">
														<i class="fas fa-trash-alt me-1"></i>Xóa
													</button>
												</td>
											</tr>

											<!-- 🧩 MODAL SỬA MÃ GIẢM GIÁ CHO TỪNG DÒNG -->
											<div class="modal fade" id="editDiscountModal_<?= $row['id'] ?>" tabindex="-1"
												aria-labelledby="editDiscountModalLabel_<?= $row['id'] ?>" aria-hidden="true">
												<div class="modal-dialog modal-lg modal-dialog-centered">
													<div class="modal-content border-0 shadow-lg rounded-3">
														<div class="modal-header bg-warning text-white">
															<h5 class="modal-title fw-semibold" id="editDiscountModalLabel_<?= $row['id'] ?>">
																<i class="fas fa-pen-to-square me-2"></i>Sửa mã giảm giá #<?= $row['id'] ?>
															</h5>
															<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
														</div>

														<form class="editDiscountForm" data-id="<?= $row['id'] ?>" method="POST">
															<div class="modal-body p-4">
																<div class="row g-3">
																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Mã code</label>
																		<input type="text" class="form-control" name="code"
																			value="<?= ($row['code']) ?>" required>
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Số lượng</label>
																		<input type="number" class="form-control" name="amount"
																			value="<?= (int)$row['amount'] ?>" min="0" required>
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Đã dùng</label>
																		<input type="number" class="form-control" name="used"
																			value="<?= (int)$row['used'] ?>" min="0" readonly>
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Giảm</label>
																		<input type="number" class="form-control" name="discount"
																			value="<?= (float)$row['discount'] ?>" step="0.01" required>
																		<small class="text-muted">
																			Nếu loại là phần trăm thì nhập %, nếu cố định thì nhập số tiền.
																		</small>
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Loại</label>
																		<select class="form-select" name="type">
																			<option value="fixed"   <?= $row['type'] === 'fixed'   ? 'selected' : '' ?>>Cố định</option>
																			<option value="percent" <?= $row['type'] === 'percent' ? 'selected' : '' ?>>Phần trăm</option>
																		</select>
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Đơn tối thiểu (min)</label>
																		<input type="number" class="form-control" name="min"
																			value="<?= (float)$row['min'] ?>" min="0">
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Đơn tối đa (max)</label>
																		<input type="number" class="form-control" name="max"
																			value="<?= (float)$row['max'] ?>" min="0">
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Ngày tạo (createdate)</label>
																		<input type="datetime-local"
																			class="form-control"
																			name="createdate"
																			value="<?= !empty($row['createdate']) ? date('Y-m-d\TH:i', $row['createdate']) : '' ?>">
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Ngày hết hạn (enddate)</label>
																		<input type="datetime-local"
																			class="form-control"
																			name="enddate"
																			value="<?= !empty($row['enddate']) ? date('Y-m-d\TH:i', $row['enddate']) : '' ?>">
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
											<td colspan="11" class="text-center text-muted">Không có mã giảm giá</td>
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

				<!-- 🧩 MODAL THÊM MÃ GIẢM GIÁ -->
				<div class="modal fade" id="addDiscountModal" tabindex="-1"
					aria-labelledby="addDiscountModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered">
						<div class="modal-content border-0 shadow-lg rounded-3">
							<div class="modal-header bg-primary text-white">
								<h5 class="modal-title fw-semibold" id="addDiscountModalLabel">
									<i class="fas fa-plus-circle me-2"></i>Thêm mã giảm giá
								</h5>
								<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
							</div>

							<form class="addDiscountForm" method="POST">
								<div class="modal-body p-4">
									<div class="row g-3">
										<!-- Mã code + random -->
										<div class="col-md-4">
											<label class="form-label fw-semibold">Mã code</label>
											<div class="input-group">
												<input type="text" class="form-control" name="code" id="addCode"
													placeholder="Nhập mã hoặc bấm random" required>
												<button class="btn btn-outline-secondary" type="button" id="btnRandomCode"
														title="Random 8 ký tự">
													<i class="fas fa-random me-1"></i>Random
												</button>
											</div>
										</div>

										<div class="col-md-4">
											<label class="form-label fw-semibold">Số lượng</label>
											<input type="number" class="form-control" name="amount"
												value="1" min="1" required>
										</div>

										<!-- used mặc định = 0 -->
										<input type="hidden" name="used" value="0">

										<div class="col-md-4">
											<label class="form-label fw-semibold">Giảm</label>
											<input type="number" class="form-control" name="discount"
												step="0.01" value="0" required>
											<small class="text-muted">
												Nếu loại là phần trăm thì nhập %, nếu cố định thì nhập số tiền.
											</small>
										</div>

										<div class="col-md-4">
											<label class="form-label fw-semibold">Loại</label>
											<select class="form-select" name="type">
												<option value="fixed">Cố định</option>
												<option value="percent">Phần trăm</option>
											</select>
										</div>

										<div class="col-md-4">
											<label class="form-label fw-semibold">Đơn tối thiểu (min)</label>
											<input type="number" class="form-control" name="min" value="0" min="0">
										</div>

										<div class="col-md-4">
											<label class="form-label fw-semibold">Đơn tối đa (max)</label>
											<input type="number" class="form-control" name="max" value="0" min="0">
										</div>

										<div class="col-md-4">
											<label class="form-label fw-semibold">Ngày tạo (createdate)</label>
											<input type="datetime-local"
												class="form-control"
												name="createdate"
												value="<?= date('Y-m-d\TH:i') ?>">
										</div>

										<div class="col-md-4">
											<label class="form-label fw-semibold">Ngày hết hạn (enddate)</label>
											<input type="datetime-local"
												class="form-control"
												name="enddate"
												placeholder="Chọn ngày hết hạn">
										</div>


									</div>
								</div>

								<div class="modal-footer bg-light">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
										<i class="fas fa-times me-1"></i>Đóng
									</button>
									<button type="submit" class="btn btn-primary fw-semibold">
										<i class="fas fa-save me-1"></i>Thêm mới
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<script>
					"use strict";

					document.addEventListener("DOMContentLoaded", () => {
						const apiUrl = "/ajax/admin/features/discount.php";

						// ==================================================
						// 🔧 HÀM TIỆN ÍCH: RANDOM MÃ CODE
						// ==================================================
						function generateRandomCode(length = 8) {
							const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
							let result = "";
							for (let i = 0; i < length; i++) {
								result += chars.charAt(Math.floor(Math.random() * chars.length));
							}
							return result;
						}

						// Nút random mã cho form thêm mới
						const btnRandom = document.getElementById("btnRandomCode");
						const inputCode = document.getElementById("addCode");

						if (btnRandom && inputCode) {
							btnRandom.addEventListener("click", () => {
								inputCode.value = generateRandomCode(8);
								inputCode.focus();
								inputCode.select();
							});
						}

						// ==================================================
						// 🟢 THÊM MÃ GIẢM GIÁ (AJAX)
						// ==================================================
						const addForm = document.querySelector(".addDiscountForm");
						addForm?.addEventListener("submit", async (e) => {
							e.preventDefault();
							const form = e.target;
							const fd = new FormData(form);
							fd.append("action", "ADD_DISCOUNT");
							
							try {
								const res = await fetch(apiUrl, {
									method: "POST",
									body: fd
								});
								const data = await res.json();
	
								if (data.status === "success") {
									showAlert3(
										"success",
										"Thành công",
										"Đã thêm mã giảm giá mới vào hệ thống!",
										2000,
										() => location.reload()
									);
									bootstrap.Modal
										.getInstance(document.getElementById("addDiscountModal"))
										?.hide();
								} else {
									showAlert3(
										"error",
										"Thất bại",
										data.message || "Không thể thêm mã giảm giá!"
									);
								}
							} catch {
								showAlert3(
									"error",
									"Lỗi kết nối",
									"Không thể gửi dữ liệu lên máy chủ!"
								);
							}
						}); 

						// ==================================================
						// 🟣 SỬA MÃ GIẢM GIÁ (AJAX)
						// ==================================================
						document.addEventListener("submit", async (e) => {
							const form = e.target.closest(".editDiscountForm");
							if (!form) return;

							e.preventDefault();

							const id = form.dataset.id;
							const fd = new FormData(form);
							fd.append("id", id);
							fd.append("action", "UPDATE_DISCOUNT");

							try {
								const res = await fetch(apiUrl, {
									method: "POST",
									body: fd
								});
								const data = await res.json();

								if (data.status === "success") {
									showAlert3(
										"success",
										"Thành công",
										data.message || "Cập nhật mã giảm giá thành công!",
										1500,
										() => location.reload()
									);
									bootstrap.Modal.getInstance(form.closest(".modal"))?.hide();
								} else {
									showAlert3(
										"error",
										"Lỗi",
										data.message || "Không thể cập nhật mã giảm giá!"
									);
								}
							} catch {
								showAlert3(
									"error",
									"Kết nối thất bại",
									"Không thể gửi yêu cầu lên máy chủ!"
								);
							}
						});

						// ==================================================
						// 🟡 CẬP NHẬT TRẠNG THÁI MÃ GIẢM GIÁ (AJAX)
						// ==================================================
						document.addEventListener("change", async (e) => {
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
										action: "UPDATE_DISCOUNT_STATUS",
										id,
										status: newStatus
									})
								});
								const data = await res.json();

								if (data.status === "success") {
									showAlert3(
										"success",
										"Thành công",
										`Mã giảm giá #${id} đã được ${newStatus === "on" ? "kích hoạt" : "tạm tắt"}.`
									);
								} else {
									showAlert3(
										"error",
										"Lỗi",
										data.message || "Không thể cập nhật trạng thái."
									);
									toggle.checked = !toggle.checked;
								}
							} catch {
								showAlert3(
									"error",
									"Kết nối thất bại",
									"Không thể gửi yêu cầu lên máy chủ."
								);
								toggle.checked = !toggle.checked;
							} finally {
								toggle.disabled = false;
							}
						});

						// ==================================================
						// 🔴 XÓA MÃ GIẢM GIÁ (AJAX)
						// ==================================================
						document.addEventListener("click", (e) => {
							const btn = e.target.closest(".btn-delete-discount");
							if (!btn) return;

							const id = btn.dataset.id;
							const code = btn.dataset.code || `#${id}`;

							Swal.fire({
								icon: "warning",
								title: "Xác nhận xóa?",
								html: `<div class="fw-semibold text-danger">Bạn có chắc muốn xóa mã giảm giá <b>${code}</b>?</div>
									<small class="text-muted">Hành động này không thể hoàn tác.</small>`,
								showCancelButton: true,
								confirmButtonText: "Xóa ngay",
								cancelButtonText: "Hủy",
								confirmButtonColor: "#dc3545",
								cancelButtonColor: "#6c757d",
								reverseButtons: true
							}).then(async (result) => {
								if (!result.isConfirmed) return;

								try {
									const res = await fetch(apiUrl, {
										method: "POST",
										headers: { "Content-Type": "application/x-www-form-urlencoded" },
										body: new URLSearchParams({
											action: "DELETE_DISCOUNT",
											id
										})
									});

									const data = await res.json();
									if (data.status === "success") {
										showAlert3(
											"success",
											"Thành công",
											data.message || `Đã xóa mã giảm giá ${code}!`,
											1800,
											() => location.reload()
										);
									} else {
										showAlert3(
											"error",
											"Lỗi",
											data.message || "Không thể xóa mã giảm giá này!"
										);
									}
								} catch {
									showAlert3(
										"error",
										"Kết nối thất bại",
										"Không thể gửi yêu cầu lên máy chủ!"
									);
								}
							});
						});

						// ==================================================
						// 🧭 PHÂN TRANG + LỌC CLIENT-SIDE CHO DISCOUNT
						// ==================================================
						const TOTAL_PAGES = <?= (int)$total_pages ?>;
						const CURRENT_PAGE = <?= (int)$page ?>;

						const tableBody = document.getElementById("discountTableBody");
						if (tableBody) {
							const originalRows = Array.from(tableBody.querySelectorAll("tr")).map((tr) =>
								tr.cloneNode(true)
							);

							const filterEls = {
								code: document.getElementById("filterCode"),
								type: document.getElementById("filterType"),
								reset: document.getElementById("resetFilterDiscount"),
								limit: document.getElementById("limitSelect"),
								sort: document.getElementById("sortSelect")
							};

							function applyFilter() {
								const codeVal = filterEls.code?.value.trim().toLowerCase() || "";
								const typeVal = filterEls.type?.value.toLowerCase() || "";

								const filtered = originalRows.filter((tr) => {
									const tds = tr.querySelectorAll("td");
									if (tds.length < 2) return false;

									// cột 0: ID, cột 1: mã code
									const idText = tds[0].innerText.toLowerCase();
									const codeText = tds[1].innerText.toLowerCase();

									// type lấy từ data-type: fixed / percent
									const rowType = (tr.dataset.type || "").toLowerCase();

									const matchCode =
										!codeVal ||
										idText.includes(codeVal) ||
										codeText.includes(codeVal);

									const matchType = !typeVal || rowType === typeVal;

									return matchCode && matchType;
								});

								tableBody.innerHTML = filtered.length
									? filtered.map((tr) => tr.outerHTML).join("")
									: `<tr><td colspan="11" class="text-center text-muted">Không tìm thấy kết quả phù hợp</td></tr>`;
							}

							[filterEls.code, filterEls.type].forEach((el) => {
								el?.addEventListener("input", applyFilter);
								el?.addEventListener("change", applyFilter);
							});

							filterEls.reset?.addEventListener("click", (e) => {
								e.preventDefault();
								if (filterEls.code) filterEls.code.value = "";
								if (filterEls.type) filterEls.type.value = "";
								if (filterEls.limit) filterEls.limit.value = "10";
								if (filterEls.sort) filterEls.sort.value = "asc";

								tableBody.innerHTML = originalRows
									.map((tr) => tr.outerHTML)
									.join("");

								window.location.href =
									window.location.origin + window.location.pathname;
							});

							// ==================================================
							// 📄 PHÂN TRANG
							// ==================================================
							function goToPage(newPage) {
								newPage = Math.max(1, Math.min(newPage, TOTAL_PAGES));
								const params = new URLSearchParams(window.location.search);
								params.set("page", newPage);
								params.set("limit", filterEls.limit?.value || 10);
								params.set("sort", filterEls.sort?.value || "asc");
								window.location.href = `${window.location.pathname}?${params.toString()}`;
							}

							document.querySelectorAll(".pagination .page-link").forEach((link) => {
								link.addEventListener("click", (e) => {
									e.preventDefault();
									const li = link.closest(".page-item");
									if (li.classList.contains("disabled") || li.classList.contains("active"))
										return;

									let newPage = CURRENT_PAGE;
									switch (link.dataset.action) {
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
						}
					});
				</script>				
				<?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
			</div>
		</div>
		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
	</body>
</html>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Lịch sử Thẻ Cào";
		?>
		<style>
			/* Style cho modal */
			.modal-content {
				border-radius: 10px;
				overflow: hidden;
			}

			.modal-header {
				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
				color: white;
			}

			.modal-header .btn-close {
				filter: invert(1) grayscale(100%) brightness(200%);
			}

			.modal-body {
				padding: 1.5rem;
			}

			.modal-footer {
				border-top: 1px solid #dee2e6;
				padding: 1rem;
			}

			/* Style cho form controls */
			.modal .form-control[readonly] {
				background-color: #f8f9fa;
				border: 1px solid #dee2e6;
				cursor: default;
			}

			.modal .form-control[readonly]:hover {
				background-color: #f8f9fa;
			}

			.modal .form-label {
				font-weight: 600;
				color: #495057;
				margin-bottom: 0.5rem;
			}

			/* Layout cho các field */
			.modal .row.g-3>[class*="col-"] {
				margin-bottom: 1rem;
			}

			/* Responsive */
			@media (max-width: 768px) {
				.modal-body {
					padding: 1rem;
				}

				.modal .row.g-3>[class*="col-"] {
					margin-bottom: 0.75rem;
				}
			}

			/* Animation cho modal */
			.modal.fade .modal-dialog {
				transform: translateY(-50px);
				transition: transform 0.3s ease-out;
			}

			.modal.show .modal-dialog {
				transform: translateY(0);
			}

			/* Badge telco với màu sắc riêng */
			.badge-telco {
				padding: 4px 10px;
				border-radius: 20px;
				font-size: 11px;
				font-weight: 600;
				text-transform: uppercase;
				border: 1px solid transparent;
			}

			.badge-telco.viettel {
				background-color: #e6f2ff;
				color: #0066cc;
				border-color: #0066cc;
			}

			.badge-telco.mobifone {
				background-color: #fff0e6;
				color: #ff6600;
				border-color: #ff6600;
			}

			.badge-telco.vinaphone {
				background-color: #f0e6ff;
				color: #6600cc;
				border-color: #6600cc;
			}

			.badge-telco.vietnamobile {
				background-color: #e6fff0;
				color: #00cc66;
				border-color: #00cc66;
			}

			.badge-telco.zing {
				background-color: #fffae6;
				color: #ffcc00;
				border-color: #ffcc00;
			}

			.badge-telco.gate {
				background-color: #ffe6e6;
				color: #cc0000;
				border-color: #cc0000;
			}

			/* Detail row animation */
			.detail-row {
				transition: all 0.3s ease-in-out;
			}

			.detail-row.show {
				animation: slideDown 0.3s ease-out;
			}

			@keyframes slideDown {
				from {
					opacity: 0;
					transform: translateY(-10px);
				}

				to {
					opacity: 1;
					transform: translateY(0);
				}
			}

			/* Detail item styling */
			.detail-item {
				padding: 8px 12px;
				background-color: rgba(0, 0, 0, 0.02);
				border-radius: 8px;
				border-left: 3px solid #007bff;
			}

			/* Button show details */
			.btn-show-details {
				border-radius: 20px;
				transition: all 0.3s;
			}

			.btn-show-details:hover {
				transform: translateY(-2px);
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			}

			/* Style cho nút copy trong input group */
			.input-group .btn-copy {
				border-left: 0;
				transition: all 0.3s ease;
				min-width: 40px;
			}

			.input-group .btn-copy:hover {
				background-color: #e9ecef;
				transform: scale(1.05);
			}

			.input-group .btn-copy.copy-success {
				background-color: #d4edda;
				border-color: #c3e6cb;
				color: #155724;
			}

			/* Hiệu ứng khi copy thành công */
			@keyframes copyPulse {
				0% {
					transform: scale(1);
				}

				50% {
					transform: scale(1.1);
				}

				100% {
					transform: scale(1);
				}
			}

			.btn-copy.copy-success i {
				animation: copyPulse 0.5s ease;
			}

			/* Style cho nút toggle password */
			.btn-toggle-pass.active {
				background-color: #e9ecef;
				border-color: #86b7fe;
			}

			.btn-toggle-pass i {
				transition: transform 0.3s ease;
			}

			.btn-toggle-pass:hover i {
				transform: scale(1.1);
			}
		</style>
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
					$total_records = $ketnoi->num_rows("SELECT * FROM `card_history`");
					
					// Tổng số trang
					$total_pages = ceil($total_records / $limit);
					
					// Lấy dữ liệu theo trang + sắp xếp
					$rows = $ketnoi->get_list("SELECT * FROM `card_history` $orderBy LIMIT $offset, $limit");
					
					// Tính chỉ số hiển thị
					$from_record = $total_records > 0 ? $offset + 1 : 0;
					$to_record   = min($offset + $limit, $total_records);
				?>
				<div class="card">
					<!-- ================= HEADER ================= -->
					<div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
						<h4 class="card-title mb-0 text-uppercase fw-semibold">
							<i class="fas fa-server text-primary me-2"></i><?php echo $title?>
						</h4>
					</div>
					<!-- ================= FILTER CARD HISTORY ================= -->
					<div class="card-body">
						<form id="filterHistoryForm" class="row g-3 align-items-center flex-wrap justify-content-between">
							<!-- ID -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-hashtag text-primary"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterId" placeholder="ID giao dịch">
								</div>
							</div>
							<!-- Username -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-user text-success"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterUsername" placeholder="Username">
								</div>
							</div>
							<!-- Telco -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-sim-card text-info"></i></span>
									<select class="form-select py-2 fs-6" id="filterTelco">
										<option value="">Tất cả nhà mạng</option>
										<option value="viettel">Viettel</option>
										<option value="mobifone">Mobifone</option>
										<option value="vinaphone">Vinaphone</option>
										<option value="vietnamobile">Vietnamobile</option>
										<option value="zing">Zing</option>
										<option value="gate">Gate</option>
									</select>
								</div>
							</div>
							<!-- Status -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-toggle-on text-danger"></i></span>
									<select class="form-select py-2 fs-6" id="filterStatus">
										<option value="">Tất cả trạng thái</option>
										<option value="PENDING">Đang chờ</option>
										<option value="SUCCESS">Thành công</option>
										<option value="FAILED">Thất bại</option>
									</select>
								</div>
							</div>
							<!-- Reset -->
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
					<!-- ================= BẢNG LỊCH SỬ NẠP THẺ ================= -->
					<div class="card-body pt-0">
						<div class="table-responsive">
							<table class="table table-striped align-middle mb-0">
								<thead class="table-light text-uppercase text-secondary fw-semibold">
									<tr>
										<th><i class="fas fa-hashtag me-1 text-muted"></i>ID</th>
										<th><i class="fas fa-user me-1 text-primary"></i>Username</th>
										<th><i class="fas fa-sim-card me-1 text-info"></i>Telco</th>
										<th><i class="fas fa-info-circle me-1 text-secondary"></i>Trạng thái</th>
										<th><i class="fas fa-clock me-1 text-success"></i>Thời gian</th>
										<th><i class="fas fa-eye me-1 text-warning"></i>Chi tiết</th>
									</tr>
								</thead>
								<tbody id="cardHistoryTableBody">
									<?php if (!empty($rows)): ?>
									<?php foreach ($rows as $row): ?>
									<tr data-id="<?= $row['id'] ?>"
										data-username="<?= ($row['username']) ?>"
										data-telco="<?= ($row['telco']) ?>"
										data-amount="<?= $row['amount'] ?>"
										data-serial="<?= ($row['serial']) ?>"
										data-code="<?= ($row['code']) ?>"
										data-request-id="<?= ($row['request_id']) ?>"
										data-status="<?= ($row['status']) ?>"
										data-timestamp="<?= $row['time'] ?>">
										<!-- ID -->
										<td class="fw-semibold"><?= $row['id'] ?></td>
										<!-- Username -->
										<td class="fw-semibold text-primary">
											<?= ($row['username']) ?>
										</td>
										<!-- Telco -->
										<td>
											<span class="badge badge-telco <?= ($row['telco']) ?>">
											<?= strtoupper($row['telco']) ?>
											</span>
										</td>
										<!-- Status -->
										<td>
											<select class="form-select form-select-sm status-select fancy-status" data-id="<?= $row['id'] ?>">
												<option value="PENDING" <?= $row['status'] === 'PENDING' ? 'selected' : '' ?>>
													⏳ Đang chờ
												</option>
												<option value="SUCCESS" <?= $row['status'] === 'SUCCESS' ? 'selected' : '' ?>>
													✅ Thành công
												</option>
												<option value="FAILED" <?= $row['status'] === 'FAILED' ? 'selected' : '' ?>>
													❌ Thất bại
												</option>
											</select>
										</td>
										<!-- Time -->
										<td>
											<?= fmDate($row['time']) ?>
										</td>
										<!-- Action - Show Details -->
										<td>
											<button class="btn btn-sm btn-outline-info btn-show-details" 
												type="button"
												title="Xem chi tiết"
												data-id="<?= $row['id'] ?>"
												data-bs-toggle="modal"
												data-bs-target="#editCardHistoryModal_<?= $row['id'] ?>">
											<i class="fas fa-eye me-1"></i> Chi tiết
											</button>
										</td>
									</tr>
									<div class="modal fade" id="editCardHistoryModal_<?= $row['id'] ?>" tabindex="-1"
										aria-labelledby="editCardHistoryModalLabel_<?= $row['id'] ?>" aria-hidden="true">
										<div class="modal-dialog modal-lg modal-dialog-centered">
											<div class="modal-content border-0 shadow-lg rounded-3">
												<div class="modal-header bg-warning text-white">
													<h5 class="modal-title fw-semibold" id="editCardHistoryModalLabel_<?= $row['id'] ?>">
														<i class="fas fa-pen-to-square me-2"></i>Lịch sử thẻ cào #<?= $row['id'] ?> 
													</h5>
													<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
												</div>
												<form class="editCardHistoryForm" data-id="<?= $row['id'] ?>">
													<div class="modal-body p-4">
														<div class="row g-3">
															<!-- Mã code - KHÔNG có nút copy -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Mã code</label>
																<input type="text" class="form-control" name="code"
																	value="<?= ($row['code']) ?>" required readonly>
															</div>
															<!-- Giá tiền - KHÔNG có nút copy -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Giá tiền</label>
																<input type="text" class="form-control" name="amount"
																	value="<?= $row['amount'] ?> đ" required readonly>
															</div>
															<!-- Serial - KHÔNG có nút copy -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Serial</label>
																<input type="text" class="form-control" name="serial"
																	value="<?= $row['serial'] ?>" required readonly>
															</div>
															<!-- Thời gian -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Thời gian:</label>
																<input type="text" class="form-control" name="time"
																	value="<?= fmDate($row['time']) ?>" required readonly>
															</div>
														</div>
													</div>
													<div class="modal-footer bg-light">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
														<i class="fas fa-times me-1"></i>Đóng
														</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<?php endforeach; ?>
									<?php else: ?>
									<tr>
										<td colspan="6" class="text-center text-muted py-4">
											<i class="fas fa-inbox fa-2x mb-3"></i><br>
											Không có dữ liệu
										</td>
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
				<script>
					"use strict";
					
					document.addEventListener("DOMContentLoaded", () => { 		
					    // ==================================================
					    // 🟡 CẬP NHẬT TRẠNG THÁI (AJAX)
					    // ==================================================
					    document.addEventListener("change", async e => { 
					        const select = e.target.closest(".status-select");
					        if (!select) return;
					
					        const id = select.dataset.id;
					        const newStatus = select.value;
					
					        select.disabled = true;
					
					        try {
					            let formData = new FormData();
					            formData.append("action", "UPDATE_STATUS");
					            formData.append("id", id);
					            formData.append("status", newStatus);
					
					            const res = await fetch("/ajax/admin/history/card_history.php", {
					                method: "POST",
					                body: formData
					            });
					
					            const data = await res.json();
					
					            if (data.status !== "success") {
					                showAlert3("error", "Lỗi", data.msg || "Không thể cập nhật trạng thái!");
					                select.checked = !select.checked;
					            } else {
					                showAlert3("success", "Thành công", "Cập nhật trạng thái thành công!");
					            }
					
					        } catch {
					            showAlert3("error", "Lỗi kết nối", "Không thể gửi yêu cầu!");
					            select.checked = !select.checked;
					        }
					
					        select.disabled = false;
					    }); 
						
						// ==================================================
						// 🔍 FILTER CARD HISTORY 
						// ================================================== 
					
						// Body bảng
						const tableBody = document.getElementById("cardHistoryTableBody");
					
						if (!tableBody) {
							console.error("Không tìm thấy bảng cardHistoryTableBody");
							return;
						}
					
						// Clone toàn bộ row ban đầu → dùng lại khi reset
						const originalRows = Array.from(tableBody.querySelectorAll("tr")).map(tr => tr.cloneNode(true));
					
						// ================== FILTER ELEMENTS ==================
						const filterEls = {
							id: document.getElementById("filterId"),
							username: document.getElementById("filterUsername"),
							telco: document.getElementById("filterTelco"),
							status: document.getElementById("filterStatus"),
							reset: document.getElementById("resetFilter"),
							limit: document.getElementById("limitSelect"),
							sort: document.getElementById("sortSelect"),
						};
					
						// ================== APPLY FILTER ================== 
						function applyFilter() {
							const idVal = filterEls.id.value.trim().toLowerCase();
							const userVal = filterEls.username.value.trim().toLowerCase();
							const telcoVal = filterEls.telco.value; // Giữ nguyên để so sánh
							const statusVal = filterEls.status.value;
					
							const filtered = originalRows.filter(tr => {
								const tds = tr.querySelectorAll("td");
								if (tds.length < 5) return false;
					
								// 1. Lấy ID
								const id = tds[0]?.textContent?.toLowerCase() || "";
								
								// 2. Lấy Username
								const user = tds[1]?.textContent?.toLowerCase() || "";
								
								// 3. Lấy Telco - Lấy từ class của badge
								const telcoBadge = tds[2]?.querySelector(".badge-telco");
								let telco = "";
								if (telcoBadge) {
									// Lấy class telco từ badge
									const classList = Array.from(telcoBadge.classList);
									// Tìm class không phải là 'badge-telco', 'badge' hay các utility classes
									const telcoClass = classList.find(cls => 
										cls !== 'badge-telco' && cls !== 'badge' && 
										!cls.includes('bg-') && !cls.includes('text-')
									);
									telco = telcoClass || telcoBadge.textContent.trim().toLowerCase();
								}
								
								// 4. Lấy Status
								const statusSelect = tds[3]?.querySelector("select");
								const status = statusSelect ? statusSelect.value : ""; 
								
								// 1. Filter ID (tìm kiếm gần đúng)
								if (idVal && !id.includes(idVal)) return false;
								
								// 2. Filter Username (tìm kiếm gần đúng)
								if (userVal && !user.includes(userVal)) return false;
								
								// 3. Filter Telco - So sánh không phân biệt hoa thường
								if (telcoVal && telco.toLowerCase() !== telcoVal.toLowerCase()) {
									return false;
								}
								
								// 4. Filter Status
								if (statusVal && status !== statusVal) return false;
								
								return true;
							});
					
							// Cập nhật bảng
							if (filtered.length > 0) {
								tableBody.innerHTML = filtered.map(tr => {
									// Cần clone lại để tránh reference issues
									const newRow = tr.cloneNode(true);
									
									// Gắn lại sự kiện cho các nút chi tiết (nếu có)
									const detailBtn = newRow.querySelector('.btn-show-details');
									if (detailBtn) {
										const id = detailBtn.dataset.id || detailBtn.getAttribute('data-id');
										detailBtn.addEventListener('click', function() {
											// Mở modal tương ứng
											const modalId = `editCardHistoryModal_${id}`;
											const modalElement = document.getElementById(modalId);
											if (modalElement) {
												const modal = new bootstrap.Modal(modalElement);
												modal.show();
											}
										});
									}
									
									return newRow.outerHTML;
								}).join("");
							} else {
								tableBody.innerHTML = `<tr>
									<td colspan="6" class="text-center text-muted py-4">
										<i class="fas fa-search fa-2x mb-3"></i><br>
										Không tìm thấy kết quả phù hợp
									</td>
								</tr>`;
							}
						}
					
						// ================== GẮN SỰ KIỆN FILTER ==================
						[
							filterEls.id, 
							filterEls.username, 
							filterEls.telco, 
							filterEls.status
						].forEach(el => {
							if (el) {
								// Đối với input text, sử dụng input event
								if (el.type === 'text') {
									el.addEventListener("input", applyFilter);
								}
								// Đối với select, sử dụng change event
								else if (el.type === 'select-one') {
									el.addEventListener("change", applyFilter);
								}
								// Fallback cho các element khác
								else {
									el.addEventListener("input", applyFilter);
									el.addEventListener("change", applyFilter);
								}
							}
						});
					
						// ================== RESET FILTER ==================
						if (filterEls.reset) {
							filterEls.reset.addEventListener("click", e => {
								e.preventDefault();
								
								// Reset giá trị filter
								filterEls.id.value = "";
								filterEls.username.value = "";
								filterEls.telco.value = "";
								filterEls.status.value = "";
					
								// Reset limit và sort (nếu có)
								if (filterEls.limit) filterEls.limit.value = "10";
								if (filterEls.sort) filterEls.sort.value = "asc";
					
								// Khôi phục bảng gốc
								tableBody.innerHTML = originalRows.map(tr => tr.outerHTML).join("");
								
								// Không reload trang, chỉ reset local
								window.location.href = window.location.origin + window.location.pathname;
							});
						}
					
						// Áp dụng filter ngay khi load
						applyFilter();
					
						// ==================================================
					    // 🧭 PHÂN TRANG + LỌC CLIENT-SIDE
					    // ==================================================
					    const TOTAL_PAGES = <?= (int)$total_pages ?>;
					    const CURRENT_PAGE = <?= (int)$page ?>;
					
					    // ================== PHÂN TRANG ==================
					    function goToPage(newPage) {
					        newPage = Math.max(1, Math.min(newPage, TOTAL_PAGES));
					        const params = new URLSearchParams(window.location.search);
					
					        params.set("page", newPage);
					        params.set("limit", filterEls.limit?.value || 10);
					        params.set("sort", filterEls.sort?.value || "asc");
					
					        window.location.href = `${window.location.pathname}?${params.toString()}`;
					    }
					
					    // Sự kiện click phân trang
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
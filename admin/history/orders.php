<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Đơn hàng đã đặt";
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
					$total_records = $ketnoi->num_rows("SELECT * FROM `orders`");
					
					// Tổng số trang
					$total_pages = ceil($total_records / $limit);
					
					// Lấy dữ liệu theo trang + sắp xếp
					$rows = $ketnoi->get_list("SELECT * FROM `orders` $orderBy LIMIT $offset, $limit");
					
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
					<!-- ================= FILTER ORDERS ================= -->
					<div class="card-body">
						<form id="filterOrdersForm" class="row g-3 align-items-center flex-wrap justify-content-between">
							<!-- ID -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-hashtag text-primary"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterId" placeholder="ID user">
								</div>
							</div>
							<!-- Username -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-user text-success"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterUsername" placeholder="Họ tên người dùng">
								</div>
							</div>
							<!-- Name -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-envelope text-info"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterName" placeholder="Tên gói">
								</div>
							</div>  
							<!-- Code -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-barcode text-info"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterCode" placeholder="Mã đơn hàng">
								</div>
							</div>
							<!-- Level -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-user-shield text-primary"></i></span>
									<select class="form-select py-2 fs-6" id="filterLevel">
										<option value="">Trạng thái</option>
										<option value="thanhcong">Thành công</option>
										<option value="choxuly">Chờ xử lý</option>
										<option value="thatbai">Thất bại</option>
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
                    <!-- ================= BẢNG QUẢN LÝ ORDERS ================= -->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="table-light align-middle">
                                    <tr>
                                        <th><i class="fas fa-hashtag me-1 text-muted"></i>ID</th>
                                        <th><i class="fas fa-user me-1 text-primary"></i>Username</th>
                                        <th><i class="fas fa-file-signature me-1 text-success"></i>Name</th>
                                        <th><i class="fas fa-barcode me-1 text-info"></i>Code</th>
                                        <th><i class="fas fa-clock me-1 text-warning"></i>Thời gian mua</th>
                                        <th><i class="fas fa-circle-info me-1 text-danger"></i>Trạng thái</th>
                                        <th class="text-center"><i class="fas fa-cogs me-1 text-dark"></i>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="ordersTableBody">
                                    <?php if (!empty($rows)): ?>
                                    <?php foreach ($rows as $row): ?>
                                    <tr data-id="<?= $row['id'] ?>"
                                        data-username="<?= ($row['username']) ?>"
                                        data-name="<?= ($row['name']) ?>"
                                        data-code="<?= ($row['code']) ?>"
                                        data-billing-cycle="<?= $row['billing_cycle'] ?>"
                                        data-quantity="<?= $row['quantity'] ?>"
                                        data-total-money="<?= $row['total_money'] ?>"
                                        data-balance-before="<?= $row['balance_before'] ?>"
                                        data-balance-after="<?= $row['balance_after'] ?>"
                                        data-status="<?= $row['status'] ?>"
                                        data-created-at="<?= $row['created_at'] ?>">
                                        <!-- ID -->
                                        <td class="fw-semibold"><?= $row['id'] ?? '' ?></td>
                                        <!-- Username -->
                                        <td class="fw-semibold text-primary"> 
											<?= !empty($row['username']) ? ($row['username']) : 'N/A' ?> 
                                        </td>
                                        <!-- Name -->
                                        <td>  
											<span class="badge bg-success-subtle text-success">
												<?= !empty($row['name']) ? ($row['name']) : 'N/A' ?>
                                            </span>
                                        </td>
                                        <!-- Code -->
                                        <td> 
											<span class="badge bg-info-subtle text-info">
												<?= !empty($row['code']) ? ($row['code']) : 'N/A' ?>
                                            </span>
                                        </td>
                                        <!-- Thời gian mua -->
                                        <td class="fw-bold">
											<?= !empty($row['created_at']) ? fmDate($row['created_at']) : 'N/A' ?>  
                                        </td>
                                        <!-- Trạng thái -->
                                        <td>
                                            <?php if ($row['status'] == 'thanhcong'): ?> 
                                                <span class="badge bg-transparent border border-success text-success">Thành công</span>
                                            <?php elseif ($row['status'] == 'thatbai'): ?> 
                                                <span class="badge bg-transparent border border-danger text-danger">Thất bại</span>
                                            <?php else: ?> 
                                                <span class="badge bg-transparent border border-warning text-warning">Chờ xử lý</span>
                                            <?php endif; ?>
                                        </td>
                                        <!-- Actions -->
                                        <td class="text-center">
                                            <!-- View Details Button -->
                                            <button class="btn btn-sm btn-info btn-view-order" 
                                                type="button"
                                                title="Xem chi tiết"
                                                data-id="<?= $row['id'] ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewOrderModal_<?= $row['id'] ?>"> 
                                                <i class="fas fa-eye me-1"></i> Xem
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal View Order Details -->
                                    <div class="modal fade" id="viewOrderModal_<?= $row['id'] ?>" tabindex="-1"
                                        aria-labelledby="viewOrderModalLabel_<?= $row['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg rounded-3">
                                                <div class="modal-header bg-info text-white">
                                                    <h5 class="modal-title fw-semibold" id="viewOrderModalLabel_<?= $row['id'] ?>">
                                                        <i class="fas fa-receipt me-2"></i>Chi tiết đơn hàng #<?= $row['id'] ?>
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
												<form class="editOrderForm" data-id="<?= $row['id'] ?>">
													<div class="modal-body p-4">
														<div class="row g-3">  
															<!-- Billing Cycle -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Chu kỳ thanh toán</label>
																<input type="text" class="form-control" readonly
																	value="<?= !empty($row['billing_cycle']) ? ($row['billing_cycle']) : 'N/A' ?>">
															</div>
															<!-- Quantity -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Số lượng</label>
																<input type="text" class="form-control" readonly
																	value="<?= !empty($row['quantity']) ? ($row['quantity']) : 'N/A' ?>">
															</div>
															<!-- Total Money -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Tổng tiền</label>
																<input type="text" class="form-control" readonly
																	value="<?= isset($row['total_money']) ? money($row['total_money']) . ' đ' : 'N/A' ?>">
															</div>
															<!-- Balance Before -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Số dư trước</label>
																<input type="text" class="form-control" readonly
																	value="<?= isset($row['balance_before']) ? money($row['balance_before']) . ' đ' : 'N/A' ?>">
															</div>
															<!-- Balance After -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Số dư sau</label>
																<input type="text" class="form-control" readonly
																	value="<?= isset($row['balance_after']) ? money($row['balance_after']) . ' đ' : 'N/A' ?>">
															</div>
															<!-- Status -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Trạng thái đơn hàng</label> 
																<select class="form-select" name="status" required>
																	<option value="thanhcong" <?= $row['status'] == 'thanhcong' ? 'selected' : '' ?>>Thành công</option>
																	<option value="choxuly" <?= $row['status'] == 'choxuly' ? 'selected' : '' ?>>Chờ xử lý</option>
																	<option value="thatbai" <?= $row['status'] == 'thatbai' ? 'selected' : '' ?>>Thất bại</option>
																</select>
															</div>
															<!-- Created At -->
															<div class="col-md-12">
																<label class="form-label fw-semibold">Thời gian tạo</label>
																<input type="text" class="form-control" readonly
																	value="<?= !empty($row['created_at']) ? fmDate($row['created_at']) : 'N/A' ?>">
															</div>
														</div>
														
														<!-- Balance Summary - Chỉ hiển thị nếu có dữ liệu số tiền -->
														<?php 
															$hasBalanceData = isset($row['balance_before']) || isset($row['total_money']) || isset($row['balance_after']);
														?>
														<?php if ($hasBalanceData): ?>
														<div class="row mt-4">
															<div class="col-12">
																<div class="card border border-primary">
																	<div class="card-header bg-primary bg-opacity-10 text-primary">
																		<h6 class="mb-0"><i class="fas fa-wallet me-2"></i>Tóm tắt số dư</h6>
																	</div>
																	<div class="card-body">
																		<div class="row text-center">
																			<!-- Balance Before -->
																			<div class="col-4">
																				<div class="p-3 bg-light rounded">
																					<small class="text-muted d-block">Số dư trước</small>
																					<h5 class="mb-0 text-primary">
																						<?= isset($row['balance_before']) ? money($row['balance_before']) . ' đ' : 'N/A' ?>
																					</h5>
																				</div>
																			</div>
																			<!-- Total Money Change -->
																			<div class="col-4">
																				<?php if (isset($row['total_money']) && $row['total_money'] != 0): ?>
																				<div class="p-3 <?= $row['total_money'] > 0 ? 'bg-danger bg-opacity-10' : 'bg-success bg-opacity-10' ?> rounded">
																					<small class="d-block"><?= $row['total_money'] > 0 ? 'Trừ tiền' : 'Thêm tiền' ?></small>
																					<h5 class="mb-0 <?= $row['total_money'] > 0 ? 'text-danger' : 'text-success' ?>">
																						<?= $row['total_money'] > 0 ? '-' : '+' ?><?= money(abs($row['total_money'])) ?> đ
																					</h5>
																				</div>
																				<?php else: ?>
																				<div class="p-3 bg-light rounded">
																					<small class="text-muted d-block">Thay đổi</small>
																					<h5 class="mb-0 text-muted">0 đ</h5>
																				</div>
																				<?php endif; ?>
																			</div>
																			<!-- Balance After -->
																			<div class="col-4">
																				<div class="p-3 bg-light rounded">
																					<small class="text-muted d-block">Số dư sau</small>
																					<h5 class="mb-0 text-success">
																						<?= isset($row['balance_after']) ? money($row['balance_after']) . ' đ' : 'N/A' ?>
																					</h5>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<?php endif; ?>
													</div>
													<div class="modal-footer bg-light"> 
														<button type="submit" class="btn btn-warning fw-semibold">
															<i class="fas fa-save me-1"></i>Cập nhật
														</button>
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
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-receipt fa-2x mb-3"></i><br>
                                            Không có dữ liệu đơn hàng
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

						const urlApi = "/ajax/admin/history/orders.php";  	

						document.addEventListener("submit", async e => {
							const form = e.target.closest(".editOrderForm");
							if (!form) return;
					
							e.preventDefault();
							const id = form.dataset.id; 
							
							const fd = new FormData(form);
							fd.append("id", id);
							fd.append("action", "UPDATE_ORDER_STATUS"); 
					
							try {
								const res = await fetch(urlApi, {
									method: "POST",
									body: fd
								});
								const data = await res.json();
					
								if (data.status === "success") {
									showAlert3("success", "Thành công", data.message || "Cập nhật thành công!", 1500, () => {
										location.reload();
									});
									bootstrap.Modal.getInstance(form.closest(".modal"))?.hide();
								} else {
									showAlert3("error", "Lỗi", data.message || "Không thể cập nhật người dùng!");
								}
							} catch {
								showAlert3("error", "Kết nối thất bại", "Không thể gửi yêu cầu lên máy chủ!");
							}
						});

						// ==================================================
						// 🔍 FILTER ORDERS 
						// ==================================================  
						const tableBody = document.getElementById("ordersTableBody");

						if (tableBody) {
							// Clone toàn bộ row ban đầu
							const originalRows = Array.from(tableBody.querySelectorAll("tr")).map(tr => tr.cloneNode(true));

							// Filter elements - thêm filterCode
							const filters = {
								id: document.getElementById("filterId"),
								username: document.getElementById("filterUsername"),
								name: document.getElementById("filterName"),
								code: document.getElementById("filterCode"), // Thêm filterCode
								level: document.getElementById("filterLevel"),
								reset: document.getElementById("resetFilter"),
								limit: document.getElementById("limitSelect"),
								sort: document.getElementById("sortSelect"), 
							};

							// Apply filter function
							function applyFilter() {
								const values = {
									id: filters.id?.value.trim().toLowerCase() || "",
									username: filters.username?.value.trim().toLowerCase() || "",
									name: filters.name?.value.trim().toLowerCase() || "",
									code: filters.code?.value.trim().toLowerCase() || "", // Thêm code
									level: filters.level?.value || "",
								};

								const filtered = originalRows.filter(tr => {
									// Nếu là row "Không có dữ liệu" thì bỏ qua
									if (tr.querySelector('td[colspan]')) return false;

									const data = {
										id: tr.dataset.id?.toString().toLowerCase() || "",
										username: tr.dataset.username?.toLowerCase() || "",
										name: tr.dataset.name?.toLowerCase() || "",
										code: tr.dataset.code?.toLowerCase() || "", // Thêm code
										status: tr.dataset.status?.toString() || "",
									};

									// ID filter
									if (values.id && !data.id.includes(values.id)) return false;
									
									// Username filter
									if (values.username && !data.username.includes(values.username)) return false;
									
									// Name filter (tên gói)
									if (values.name && !data.name.includes(values.name)) return false;
									
									// Code filter (mã đơn hàng)
									if (values.code && !data.code.includes(values.code)) return false;
									
									// Status filter
									if (values.level !== "" && data.status !== values.level) return false;
									
									return true;
								});

								// Update table
								if (filtered.length > 0) {
									tableBody.innerHTML = filtered.map(tr => tr.outerHTML).join("");
								} else {
									tableBody.innerHTML = `<tr><td colspan="7" class="text-center text-muted py-4">
										<i class="fas fa-search fa-2x mb-3"></i><br>
										Không tìm thấy đơn hàng phù hợp
									</td></tr>`;
								}
							}

							// Attach events to filter inputs
							Object.values(filters).forEach(el => {
								if (el && el !== filters.reset && el !== filters.limit && el !== filters.sort) {
									el.addEventListener(el.type === 'text' ? 'input' : 'change', applyFilter);
								}
							});

							// Reset filter
							if (filters.reset) {
								filters.reset.addEventListener("click", e => {
									e.preventDefault();
									
									// Reset filter inputs
									filters.id.value = "";
									filters.username.value = "";
									filters.name.value = "";
									filters.code.value = ""; // Reset code
									filters.level.value = "";

									// Reset limit và sort (nếu có)
									if (filters.limit) filters.limit.value = "10";
									if (filters.sort) filters.sort.value = "asc";
									
									// Reset table to original state
									tableBody.innerHTML = originalRows.map(tr => tr.outerHTML).join("");
									window.location.href = window.location.origin + window.location.pathname;
								});
							}

							// Initial filter application
							applyFilter();
						}
			
						// ==================================================
						// 🧭 PHÂN TRANG + LỌC CLIENT-SIDE
						// ==================================================
						const TOTAL_PAGES = <?= (int)$total_pages ?>;
						const CURRENT_PAGE = <?= (int)$page ?>;
						const CURRENT_LIMIT = <?= (int)$limit ?>;
						const CURRENT_SORT = '<?= addslashes($sort) ?>';

						// ================== PHÂN TRANG ==================
						function goToPage(newPage) {
							newPage = Math.max(1, Math.min(newPage, TOTAL_PAGES));
							const params = new URLSearchParams(window.location.search);

							// Lấy các tham số hiện tại từ URL hoặc dùng giá trị mặc định từ PHP
							const limit = params.get('limit') || CURRENT_LIMIT;
							const sort = params.get('sort') || CURRENT_SORT;

							params.set("page", newPage);
							params.set("limit", limit);
							params.set("sort", sort);

							window.location.href = `${window.location.pathname}?${params.toString()}`;
						}

						// Sự kiện click phân trang
						document.addEventListener('DOMContentLoaded', function() {
							const paginationLinks = document.querySelectorAll(".pagination .page-link[data-action]");
							
							paginationLinks.forEach(link => {
								link.addEventListener("click", function(e) {
									e.preventDefault();
									
									const li = this.closest(".page-item");
									if (li.classList.contains("disabled")) return;
									
									let newPage = CURRENT_PAGE;
									
									switch (this.dataset.action) {
										case "first": newPage = 1; break;
										case "prev": newPage = Math.max(1, CURRENT_PAGE - 1); break;
										case "next": newPage = Math.min(TOTAL_PAGES, CURRENT_PAGE + 1); break;
										case "last": newPage = TOTAL_PAGES; break;
									}
									
									// Chỉ chuyển trang nếu khác trang hiện tại
									if (newPage !== CURRENT_PAGE) {
										goToPage(newPage);
									}
								});
							});

							// Xử lý click vào số trang (các nút số)
							document.querySelectorAll(".pagination .page-link:not([data-action])").forEach(link => {
								link.addEventListener("click", function(e) {
									const li = this.closest(".page-item");
									if (li.classList.contains("active")) {
										e.preventDefault();
									}
									// Nếu không active, để href mặc định hoạt động
								});
							});
						});

						// ================== XỬ LÝ THAY ĐỔI LIMIT & SORT ==================
						// (Nếu bạn có dropdown để thay đổi limit và sort)
						document.addEventListener('DOMContentLoaded', function() {
							// Xử lý thay đổi limit nếu có dropdown
							const limitSelect = document.getElementById('limit-select');
							if (limitSelect) {
								limitSelect.value = CURRENT_LIMIT; // Đặt giá trị hiện tại
								limitSelect.addEventListener('change', function() {
									const params = new URLSearchParams(window.location.search);
									params.set('limit', this.value);
									params.set('page', 1); // Reset về trang 1 khi thay đổi limit
									window.location.href = `${window.location.pathname}?${params.toString()}`;
								});
							}

							// Xử lý thay đổi sort nếu có dropdown
							const sortSelect = document.getElementById('sort-select');
							if (sortSelect) {
								sortSelect.value = CURRENT_SORT; // Đặt giá trị hiện tại
								sortSelect.addEventListener('change', function() {
									const params = new URLSearchParams(window.location.search);
									params.set('sort', this.value);
									params.set('page', 1); // Reset về trang 1 khi thay đổi sort
									window.location.href = `${window.location.pathname}?${params.toString()}`;
								});
							}
						});
					});
				</script>
				<?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
			</div>
		</div>
		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
	</body>
</html>
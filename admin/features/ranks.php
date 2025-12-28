<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Xếp hạng";
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
					$total_records = $ketnoi->num_rows("SELECT * FROM `ranks`");
					
					// Tổng số trang
					$total_pages = ceil($total_records / $limit);
					
					// Lấy dữ liệu theo trang + sắp xếp
					$rows = $ketnoi->get_list("SELECT * FROM `ranks` $orderBy LIMIT $offset, $limit");
					
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
						<!-- NÚT THÊM HẠNG THÀNH VIÊN -->
						<button class="btn btn-primary fw-semibold d-flex align-items-center gap-1"
								data-bs-toggle="modal"
								data-bs-target="#addRankModal">
							<i class="fas fa-plus-circle"></i> Thêm hạng thành viên
						</button>

					</div>
					<!-- ================= FILTER ================= -->
					<div class="card-body">
						<form id="filterRankForm" class="row g-3 align-items-center flex-wrap justify-content-between">
							<!-- Tìm theo ID / Tên hạng -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text">
										<i class="fas fa-user-tag text-primary"></i>
									</span>
									<input type="text"
										class="form-control py-2 fs-6"
										id="filterRank"
										placeholder="Nhập ID hoặc tên hạng thành viên">
								</div>
							</div>

							<!-- Lọc theo trạng thái -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text">
										<i class="fas fa-toggle-on text-success"></i>
									</span>
									<select class="form-select py-2 fs-6" id="filterStatus">
										<option value="">Tất cả trạng thái</option>
										<option value="on">Hoạt động</option>
										<option value="off">Tạm tắt</option>
									</select>
								</div>
							</div>

							<!-- Lọc theo Site con -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text">
										<i class="fas fa-sitemap text-warning"></i>
									</span>
									<select class="form-select py-2 fs-6" id="filterSitecon">
										<option value="">Tất cả site con</option>
										<option value="on">Có áp dụng site con</option>
										<option value="off">Không áp dụng</option>
									</select>
								</div>
							</div>

							<!-- Lọc theo tổng nạp/điểm -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text">
										<i class="fas fa-coins text-info"></i>
									</span>
									<input type="number"
										class="form-control py-2 fs-6"
										id="filterPoint"
										min="0"
										placeholder="Tổng nạp/điểm từ...">
								</div>
							</div>

							<!-- Nút reset -->
							<div class="col-auto">
								<button type="reset"
										class="btn btn-danger px-4 py-2 fw-semibold"
										id="resetFilterRank">
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
					<!-- ================= BẢNG HẠNG THÀNH VIÊN (RANKS) ================= -->
					<div class="card-body pt-0">
						<div class="table-responsive">
							<table class="table table-striped align-middle mb-0">
								<thead class="table-light text-uppercase text-secondary fw-semibold">
									<tr>
										<th><i class="fas fa-hashtag me-1 text-muted"></i>ID</th>
										<th><i class="fas fa-user-tag me-1 text-primary"></i>Tên hạng</th>
										<th><i class="fas fa-info-circle me-1 text-secondary"></i>Mô tả</th>
										<th><i class="fas fa-image me-1 text-success"></i>Ảnh</th>
										<th><i class="fas fa-coins me-1 text-warning"></i>Min điểm/nạp</th>
										<th><i class="fas fa-coins me-1 text-warning"></i>Max điểm/nạp</th>
										<th><i class="fas fa-percent me-1 text-info"></i>Giảm %</th>
										<th><i class="fas fa-sitemap me-1 text-primary"></i>Site con</th>
										<th><i class="fas fa-toggle-on me-1 text-danger"></i>Trạng thái</th>
										<th><i class="fas fa-clock me-1 text-secondary"></i>Thời gian</th>
										<th class="text-center"><i class="fas fa-cogs me-1 text-secondary"></i>Hành động</th>
									</tr>
								</thead>

								<tbody id="rankTableBody">
									<?php if (!empty($rows)): ?>
										<?php foreach ($rows as $row): ?>
											<tr data-status="<?= $row['status'] ?>" data-sitecon="<?= $row['sitecon'] ?>">
												<td><?= $row['id'] ?></td>

												<td class="fw-semibold text-primary">
													<?= ($row['name']) ?>
												</td>

												<td>
													<small class="text-muted">
														<?= nl2br(($row['description'])) ?>
													</small>
												</td>

												<td>
													<?php if (!empty($row['image'])): ?>
														<img src="<?= ($row['image']) ?>"
															alt="image"
															class="img-thumbnail"
															style="max-height:40px;">
													<?php else: ?>
														<span class="badge bg-light text-muted">Không có</span>
													<?php endif; ?>
												</td>

												<td><?= money($row['min_points']) ?></td>
												<td><?= money($row['max_points']) ?></td>

												<td>
													<span class="badge rounded-pill bg-info-subtle text-info">
														<?= (float)$row['discount_percent'] ?>%
													</span>
												</td>

												<td>
													<span class="badge rounded-pill
														<?= $row['sitecon'] === 'on' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' ?>">
														<?= $row['sitecon'] === 'on' ? 'Áp dụng site con' : 'Không áp dụng' ?>
													</span>
												</td>

												<td>
													<div class="form-check form-switch d-inline-flex align-items-center justify-content-center">
														<input class="form-check-input toggle-status"
															type="checkbox"
															role="switch"
															data-id="<?= $row['id'] ?>"
															<?= $row['status'] == 'on' ? 'checked' : '' ?>>
													</div>
												</td>

												<td>
													<?= !empty($row['time']) ? fmDate($row['time']) : '-' ?>
												</td>

												<td class="text-center">
													<button class="btn btn-outline-primary btn-sm me-1"
															data-bs-toggle="modal"
															data-bs-target="#editRankModal_<?= $row['id'] ?>">
														<i class="fas fa-pen-to-square me-1"></i>Sửa
													</button>
													<button class="btn btn-outline-danger btn-sm btn-delete-rank"
															data-id="<?= $row['id'] ?>"
															data-name="<?= ($row['name']) ?>">
														<i class="fas fa-trash-alt me-1"></i>Xóa
													</button>
												</td>
											</tr>

											<!-- 🧩 MODAL SỬA RANK CHO TỪNG DÒNG -->
											<div class="modal fade" id="editRankModal_<?= $row['id'] ?>" tabindex="-1" method="POST" enctype="multipart/form-data"
												aria-labelledby="editRankModalLabel_<?= $row['id'] ?>" aria-hidden="true">
												<div class="modal-dialog modal-lg modal-dialog-centered">
													<div class="modal-content border-0 shadow-lg rounded-3">
														<div class="modal-header bg-warning text-white">
															<h5 class="modal-title fw-semibold" id="editRankModalLabel_<?= $row['id'] ?>">
																<i class="fas fa-pen-to-square me-2"></i>Sửa hạng thành viên #<?= $row['id'] ?>
															</h5>
															<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
														</div>

														<form class="editRankForm" data-id="<?= $row['id'] ?>" method="POST">
															<div class="modal-body p-4">
																<div class="row g-3">
																	<div class="col-md-12">
																		<label class="form-label fw-semibold">Tên hạng</label>
																		<input type="text" class="form-control" name="name"
																			value="<?= ($row['name']) ?>" required>
																	</div>

																	<div class="col-md-6">
																		<label class="form-label fw-semibold">Ảnh hiện tại</label>
																		<?php if (!empty($row['image'])): ?>
																			<div class="border rounded p-2 text-center bg-light">
																				<img src="<?= htmlspecialchars($row['image']) ?>"
																					alt="Rank image"
																					class="img-fluid rounded"
																					id="preview_rank_<?= $row['id'] ?>"
																					style="max-height: 80px;">
																			</div>
																		<?php else: ?>
																			<div class="border rounded p-3 text-center text-muted bg-light"
																				id="preview_rank_<?= $row['id'] ?>">
																				Chưa có ảnh
																			</div>
																		<?php endif; ?>
																	</div>

																	<div class="col-md-6">
																		<label class="form-label fw-semibold">Chọn ảnh mới</label>
																		<input type="file"
																			class="form-control image-input"
																			name="image_file"
																			accept="image/*"
																			data-preview="preview_rank_<?= $row['id'] ?>">

																		<!-- Lưu lại đường dẫn ảnh cũ nếu không upload mới -->
																		<input type="hidden" name="old_image" value="<?= htmlspecialchars($row['image']) ?>">

																		<small class="text-muted">
																			Nếu không chọn ảnh mới, hệ thống sẽ giữ nguyên ảnh hiện tại.
																		</small>
																	</div>


																	<div class="col-md-12">
																		<label class="form-label fw-semibold">Mô tả</label>
																		<textarea class="form-control" name="description" rows="2"><?= ($row['description']) ?></textarea>
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Min điểm/nạp</label>
																		<input type="number" class="form-control" name="min_points"
																			value="<?= (float)$row['min_points'] ?>" min="0" required>
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Max điểm/nạp</label>
																		<input type="number" class="form-control" name="max_points"
																			value="<?= (float)$row['max_points'] ?>" min="0" required>
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Giảm %</label>
																		<input type="number" class="form-control" name="discount_percent"
																			value="<?= (float)$row['discount_percent'] ?>" step="0.01" min="0">
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Áp dụng site con</label>
																		<select class="form-select" name="sitecon">
																			<option value="off" <?= $row['sitecon'] === 'off' ? 'selected' : '' ?>>Không áp dụng</option>
																			<option value="on"  <?= $row['sitecon'] === 'on'  ? 'selected' : '' ?>>Áp dụng</option>
																		</select>
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Trạng thái</label>
																		<select class="form-select" name="status">
																			<option value="on"  <?= $row['status'] === 'on' ? 'selected' : '' ?>>Hoạt động</option>
																			<option value="off" <?= $row['status'] === 'off' ? 'selected' : '' ?>>Tạm tắt</option>
																		</select>
																	</div>

																	<div class="col-md-4">
																		<label class="form-label fw-semibold">Thời gian tạo</label>
																		<input type="text" class="form-control" value="<?= fmDate($row['time']) ?>" readonly>
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
											<td colspan="11" class="text-center text-muted">Không có dữ liệu hạng thành viên</td>
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
				<!-- 🧩 MODAL THÊM HẠNG THÀNH VIÊN -->
				<div class="modal fade" id="addRankModal" tabindex="-1"
					aria-labelledby="addRankModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered">
						<div class="modal-content border-0 shadow-lg rounded-3">
							<div class="modal-header bg-primary text-white">
								<h5 class="modal-title fw-semibold" id="addRankModalLabel">
									<i class="fas fa-plus-circle me-2"></i>Thêm hạng thành viên
								</h5>
								<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
							</div>

							<form id="addRankForm" class="addRankForm" method="POST" enctype="multipart/form-data">
								<div class="modal-body p-4">
									<div class="row g-3">
										<!-- Tên hạng -->
										<div class="col-md-6">
											<label class="form-label fw-semibold">Tên hạng</label>
											<input type="text" class="form-control" name="name"
												placeholder="VD: Cộng Tác Viên Nạp 500k" required>
										</div>

										<div class="col-md-6">
											<label class="form-label fw-semibold">Chọn ảnh (logo hạng)</label>
											<input type="file"
												class="form-control image-input"
												name="image_file"
												accept="image/*"
												data-preview="addRankPreview">
											<small class="text-muted">
												Có thể bỏ trống nếu chưa có ảnh.
											</small>
										</div>

										<!-- Mô tả -->
										<div class="col-md-12">
											<label class="form-label fw-semibold">Mô tả</label>
											<textarea class="form-control" name="description" rows="2"
													placeholder="Mô tả quyền lợi, điều kiện của hạng này..."></textarea>
										</div> 

										<!-- Giảm % -->
										<div class="col-md-4">
											<label class="form-label fw-semibold">Giảm %</label>
											<input type="number" class="form-control" name="discount_percent"
												step="0.01" min="0" value="0">
										</div>

										<!-- Min / Max points -->
										<div class="col-md-4">
											<label class="form-label fw-semibold">Min điểm / số tiền nạp</label>
											<input type="number" class="form-control" name="min_points"
												min="0" value="0" required>
										</div>

										<div class="col-md-4">
											<label class="form-label fw-semibold">Max điểm / số tiền nạp</label>
											<input type="number" class="form-control" name="max_points"
												min="0" value="0" required>
										</div>

										<!-- Trạng thái -->
										<div class="col-md-6">
											<label class="form-label fw-semibold">Trạng thái</label>
											<select class="form-select" name="status">
												<option value="on">Hoạt động</option>
												<option value="off">Tạm tắt</option>
											</select>
										</div>

										<!-- Site con -->
										<div class="col-md-6">
											<label class="form-label fw-semibold">Áp dụng site con</label>
											<select class="form-select" name="sitecon">
												<option value="off">Không áp dụng</option>
												<option value="on">Áp dụng</option>
											</select>
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
						const apiUrl = "/ajax/admin/features/ranks.php";

						// ==================================================
						// 🟢 THÊM HẠNG THÀNH VIÊN (AJAX)
						// ==================================================
						const addForm = document.querySelector("#addRankForm"); // hoặc ".addRankForm"
						addForm?.addEventListener("submit", async (e) => {
							e.preventDefault();
							const form = e.target;
							const fd = new FormData(form);

							// Action BE xử lý thêm rank
							fd.append("action", "ADD_RANKS");

							try {
								const res = await fetch(apiUrl, {
									method: "POST",
									body: fd
								});
								const data = await res.json();

								if (data.status === "success") {
									showAlert33(
										"success",
										"Thành công",
										data.message || "Đã thêm hạng thành viên mới vào hệ thống!",
										2000,
										() => location.reload()
									);
									bootstrap.Modal
										.getInstance(document.getElementById("addRankModal"))
										?.hide();
								} else {
									showAlert33(
										"error",
										"Thất bại",
										data.message || "Không thể thêm hạng thành viên!"
									);
								}
							} catch {
								showAlert33(
									"error",
									"Lỗi kết nối",
									"Không thể gửi dữ liệu lên máy chủ!"
								);
							}
						});
						
						// ==================================================
						// 🟣 SỬA HẠNG THÀNH VIÊN (AJAX)
						// ==================================================
						document.addEventListener("submit", async (e) => {
							const form = e.target.closest(".editRankForm");
							if (!form) return;

							e.preventDefault();

							const id = form.dataset.id;
							const fd = new FormData(form);
							fd.append("id", id);
							fd.append("action", "UPDATE_RANKS");

							try {
								const res = await fetch(apiUrl, {
									method: "POST",
									body: fd
								});
								const data = await res.json();

								if (data.status === "success") {
									showAlert33(
										"success",
										"Thành công",
										data.message || "Cập nhật hạng thành viên thành công!",
										1500,
										() => location.reload()
									);
									bootstrap.Modal.getInstance(form.closest(".modal"))?.hide();
								} else {
									showAlert33(
										"error",
										"Lỗi",
										data.message || "Không thể cập nhật hạng thành viên!"
									);
								}
							} catch {
								showAlert33(
									"error",
									"Kết nối thất bại",
									"Không thể gửi yêu cầu lên máy chủ!"
								);
							}
						});
						
						// ==================================================
						// 🟡 CẬP NHẬT TRẠNG THÁI HẠNG THÀNH VIÊN (AJAX)
						// ==================================================
						document.addEventListener("change", async (e) => {
							const toggle = e.target.closest(".toggle-status");
							if (!toggle) return;

							const id = toggle.dataset.id;
							const newStatus = toggle.checked ? "on" : "off";

							// Khóa tạm để tránh spam click
							toggle.disabled = true;

							try {
								const res = await fetch(apiUrl, {
									method: "POST",
									headers: { "Content-Type": "application/x-www-form-urlencoded" },
									body: new URLSearchParams({
										action: "UPDATE_RANKS_STATUS",
										id,
										status: newStatus
									})
								});

								const data = await res.json();

								if (data.status === "success") {
									showAlert33(
										"success",
										"Thành công",
										`Hạng thành viên #${id} đã được ${newStatus === "on" ? "kích hoạt" : "tạm tắt"}.`
									);
								} else {
									showAlert33(
										"error",
										"Lỗi",
										data.message || "Không thể cập nhật trạng thái."
									);
									// revert trạng thái nếu lỗi
									toggle.checked = !toggle.checked;
								}
							} catch {
								showAlert33(
									"error",
									"Kết nối thất bại",
									"Không thể gửi yêu cầu lên máy chủ."
								);
								// revert trạng thái nếu lỗi mạng
								toggle.checked = !toggle.checked;
							} finally {
								toggle.disabled = false;
							}
						});
						
						// ==================================================
						// 🔴 XÓA HẠNG THÀNH VIÊN (AJAX)
						// ==================================================
						document.addEventListener("click", (e) => {
							const btn = e.target.closest(".btn-delete-rank");
							if (!btn) return;

							const id   = btn.dataset.id;
							const name = btn.dataset.name || `#${id}`;

							Swal.fire({
								icon: "warning",
								title: "Xác nhận xóa?",
								html: `<div class="fw-semibold text-danger">Bạn có chắc muốn xóa hạng thành viên <b>${name}</b>?</div>
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
											action: "DELETE_RANKS",
											id
										})
									});

									const data = await res.json();
									if (data.status === "success") {
										showAlert33(
											"success",
											"Thành công",
											data.message || `Đã xóa hạng thành viên ${name}!`,
											1800,
											() => location.reload()
										);
									} else {
										showAlert33(
											"error",
											"Lỗi",
											data.message || "Không thể xóa hạng thành viên này!"
										);
									}
								} catch {
									showAlert33(
										"error",
										"Kết nối thất bại",
										"Không thể gửi yêu cầu lên máy chủ!"
									);
								}
							});
						});


						// ==================================================
						// 🧭 PHÂN TRANG + LỌC CLIENT-SIDE CHO RANK
						// ==================================================
						const TOTAL_PAGES = <?= (int)$total_pages ?>;
						const CURRENT_PAGE = <?= (int)$page ?>;

						const tableBody = document.getElementById("rankTableBody");
						if (tableBody) {
							// Clone lại toàn bộ row gốc
							const originalRows = Array.from(tableBody.querySelectorAll("tr")).map((tr) =>
								tr.cloneNode(true)
							);

							const filterEls = {
								rank:    document.getElementById("filterRank"),     // ô ID / tên hạng
								status:  document.getElementById("filterStatus"),   // trạng thái on/off
								sitecon: document.getElementById("filterSitecon"),  // áp dụng site con
								point:   document.getElementById("filterPoint"),    // tổng nạp/điểm từ...
								reset:   document.getElementById("resetFilterRank"),
								limit:   document.getElementById("limitSelect"),
								sort:    document.getElementById("sortSelect")
							};

							function parseNumber(str) {
								if (!str) return 0;
								// loại bỏ ký tự không phải số, dấu . , -
								const cleaned = str.toString().replace(/[^\d.-]/g, "");
								const num = parseFloat(cleaned);
								return isNaN(num) ? 0 : num;
							}

							function applyFilter() {
								const keyword   = filterEls.rank?.value.trim().toLowerCase()    || "";
								const statusVal = filterEls.status?.value.trim().toLowerCase()  || "";
								const siteVal   = filterEls.sitecon?.value.trim().toLowerCase() || "";
								const pointRaw  = filterEls.point?.value.trim()                 || "";
								const pointVal  = pointRaw === "" ? 0 : parseFloat(pointRaw);

								const filtered = originalRows.filter((tr) => {
									const tds = tr.querySelectorAll("td");
									if (tds.length < 2) return false;

									// cột 0: ID, cột 1: Tên hạng
									const idText   = tds[0].innerText.toLowerCase();
									const nameText = tds[1].innerText.toLowerCase();

									// data-* trên <tr>
									const rowStatus  = (tr.dataset.status  || "").toLowerCase();   // on/off
									const rowSitecon = (tr.dataset.sitecon || "").toLowerCase();   // on/off

									// cột 4: min_points, cột 5: max_points (hiển thị đã format money)
									const minPoints = tds[4] ? parseNumber(tds[4].innerText) : 0;
									const maxPoints = tds[5] ? parseNumber(tds[5].innerText) : 0;

									// Điều kiện lọc
									const matchKeyword =
										!keyword ||
										idText.includes(keyword) ||
										nameText.includes(keyword);

									const matchStatus =
										!statusVal || rowStatus === statusVal;

									const matchSitecon =
										!siteVal || rowSitecon === siteVal;

									// Nếu không nhập point => bỏ qua điều kiện này
									// Nếu có nhập => point phải >= min và (<= max hoặc max = 0 nghĩa là không giới hạn)
									const matchPoint =
										!pointVal ||
										(minPoints <= pointVal && (maxPoints === 0 || pointVal <= maxPoints));

									return matchKeyword && matchStatus && matchSitecon && matchPoint;
								});

								tableBody.innerHTML = filtered.length
									? filtered.map((tr) => tr.outerHTML).join("")
									: `<tr><td colspan="11" class="text-center text-muted">Không tìm thấy kết quả phù hợp</td></tr>`;
							}

							// Lắng nghe thay đổi filter
							[
								filterEls.rank,
								filterEls.status,
								filterEls.sitecon,
								filterEls.point
							].forEach((el) => {
								el?.addEventListener("input", applyFilter);
								el?.addEventListener("change", applyFilter);
							});

							// Nút reset filter
							filterEls.reset?.addEventListener("click", (e) => {
								e.preventDefault();
								if (filterEls.rank)    filterEls.rank.value    = "";
								if (filterEls.status)  filterEls.status.value  = "";
								if (filterEls.sitecon) filterEls.sitecon.value = "";
								if (filterEls.point)   filterEls.point.value   = "";
								if (filterEls.limit)   filterEls.limit.value   = "10";
								if (filterEls.sort)    filterEls.sort.value    = "asc";

								tableBody.innerHTML = originalRows
									.map((tr) => tr.outerHTML)
									.join("");

								// Reload URL sạch param nếu cần
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
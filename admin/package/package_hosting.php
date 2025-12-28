<!DOCTYPE html>
<html lang="vi" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Gói hosting";
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
						$total_records = $ketnoi->num_rows("SELECT * FROM `package_hosting`");
						
						// Tổng số trang
						$total_pages = ceil($total_records / $limit);
						
						// Lấy dữ liệu theo trang + sắp xếp
						$rows = $ketnoi->get_list("SELECT * FROM `package_hosting` $orderBy LIMIT $offset, $limit");
						
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
							<button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addPackageHostingModal">
							<i class="fas fa-plus-circle me-2"></i> Thêm gói hosting
							</button>
						</div> 
                        <!-- ================= FILTER FORM ================= -->
                        <div class="card-body">
                            <form id="filterPackageForm" class="row g-3 align-items-center flex-wrap justify-content-between">

                                <!-- ID -->
                                <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hashtag text-primary"></i></span>
                                    <input type="text" class="form-control py-2 fs-6" id="filterId" placeholder="ID gói hosting">
                                </div>
                                </div>

                                <!-- Tên gói -->
                                <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-box text-success"></i></span>
                                    <input type="text" class="form-control py-2 fs-6" id="filterNameHost" placeholder="Tên gói hosting">
                                </div>
                                </div>

                                <!-- Server -->
                                <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-server text-info"></i></span>
                                    <input type="text" class="form-control py-2 fs-6" id="filterServerHost" placeholder="Server host ID">
                                </div>
                                </div>

                                <!-- Trạng thái -->
                                <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-toggle-on text-danger"></i></span>
                                    <select class="form-select py-2 fs-6" id="filterStatus">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="on">Hoạt động</option>
                                    <option value="off">Tạm tắt</option>
                                    </select>
                                </div>
                                </div>

                                <!-- Sắp xếp giá -->
                                <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-sort-amount-up-alt text-secondary"></i></span>
                                    <select class="form-select py-2 fs-6" id="sortMoney">
                                    <option value="">Sắp xếp theo giá</option>
                                    <option value="asc">Giá thấp → cao</option>
                                    <option value="desc">Giá cao → thấp</option>
                                    </select>
                                </div>
                                </div>

                                <!-- Nút reset -->
                                <div class="col-auto d-flex gap-2">
                                <button type="reset" class="btn btn-danger px-4 py-2 fw-semibold" id="resetFilter">
                                    <i class="fas fa-trash-alt me-1"></i> Xóa lọc
                                </button>
                                </div>
                            </form>

                            <!-- ================== THÔNG TIN PHÂN TRANG + SẮP XẾP ================== -->
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-3 border-top pt-3">
                                <!-- BÊN TRÁI -->
                                <div class="text-muted small order-2 order-md-1">
                                <i class="far fa-list-alt me-1"></i>
                                Hiển thị <b><?= $from_record ?></b>–<b><?= $to_record ?></b> /
                                <b><?= $total_records ?></b> bản ghi
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

                        <!-- ================= TABLE package_hosting ================= -->
                        <div class="card-body pt-0">
                            <div class="table-responsive position-relative">
                                <table class="table table-striped table-hover align-middle mb-0">
                                <thead class="table-light text-uppercase fw-semibold">
                                    <tr class="align-middle">
                                    <th><i class="fas fa-hashtag text-muted me-1"></i>ID</th>
                                    <th><i class="fas fa-box text-primary me-1"></i>Tên gói</th>
                                    <th><i class="fas fa-barcode text-success me-1"></i>Mã gói</th>
                                    <th><i class="fas fa-server text-info me-1"></i>Server Host</th>
                                    <th><i class="fas fa-coins text-warning me-1"></i>Giá tiền (VNĐ)</th>
                                    <th><i class="fas fa-hdd text-secondary me-1"></i>Dung lượng (MB)</th>
                                    <th><i class="fas fa-globe-asia text-primary me-1"></i>Domain phụ</th>
                                    <th><i class="fas fa-clone text-success me-1"></i>Alias Domain</th>
                                    <th class="text-center"><i class="fas fa-toggle-on text-danger me-1"></i>Trạng thái</th>
                                    <th class="text-center"><i class="fas fa-cogs text-dark me-1"></i>Hành động</th>
                                    </tr>
                                </thead>

                                <tbody id="packageTableBody">
                                    <?php if (!empty($rows)): ?>
                                    <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td class="fw-semibold text-primary"><?= ($row['name_host']) ?></td>
                                        <td><?= ($row['code_host']) ?></td>
                                        <td><?= ($row['server_host']) ?></td>
                                        <td class="fw-semibold text-success"><?= money($row['money']) ?></td>
                                        <td><?= ($row['disk']) ?></td>
                                        <td><?= ($row['other_domain']) ?></td>
                                        <td><?= ($row['alias_domain']) ?></td>
                                        <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                                data-id="<?= $row['id'] ?>"
                                                <?= $row['status'] === 'on' ? 'checked' : '' ?>>
                                        </div>
                                        </td>
                                        <td class="text-center">
                                        <button class="btn btn-outline-primary btn-sm me-1 btn-edit"
											data-id="<?= $row['id'] ?>"
											data-detail='<?= json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
											<i class="fas fa-pen-to-square me-1"></i> Sửa
										</button>

                                        <button class="btn btn-outline-danger btn-sm btn-delete"
                                                data-id="<?= $row['id'] ?>"
                                                data-name="<?= ($row['name_host']) ?>">
                                            <i class="fas fa-trash-alt me-1"></i>Xóa
                                        </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-3">Không có dữ liệu</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                                </table>

                                <!-- Loading overlay -->
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
                    
                    <!-- ========== MODAL THÊM GÓI HOSTING ========== -->
                    <div class="modal fade" id="addPackageHostingModal" tabindex="-1" aria-labelledby="addPackageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg rounded-3">
                                <!-- HEADER -->
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title fw-semibold" id="addPackageModalLabel">
                                        <i class="fas fa-box me-2"></i>Thêm gói Hosting mới
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- FORM -->
                                <form id="addPackageForm" method="POST">
                                    <div class="modal-body p-4">
                                        <div class="row g-3">

                                            <!-- Tên gói -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Tên gói Hosting</label>
                                                <input type="text" class="form-control" name="name_host" placeholder="Ví dụ: VN_BASIC" required>
                                            </div> 

                                            <!-- Server host -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Server Host ID</label>
                                                <input type="number" class="form-control" name="server_host" placeholder="Ví dụ: 1" required>
                                            </div>

                                            <!-- Giá tiền -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Giá tiền (VNĐ)</label>
                                                <input type="number" class="form-control" name="money" placeholder="Ví dụ: 150000" required>
                                            </div>

                                            <!-- Dung lượng -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Dung lượng (MB)</label>
                                                <input type="number" class="form-control" name="disk" placeholder="Ví dụ: 3000" required>
                                            </div>

                                            <!-- Domain phụ -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Số lượng Domain phụ</label>
                                                <input type="text" class="form-control" name="other_domain" placeholder="Ví dụ: Không giới hạn / 3 domain">
                                            </div>

                                            <!-- Alias domain -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Alias Domain</label>
                                                <input type="text" class="form-control" name="alias_domain" placeholder="Ví dụ: Không giới hạn">
                                            </div>

                                            <!-- Trạng thái -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Trạng thái</label>
                                                <select class="form-select" name="status" required>
                                                    <option value="on" selected>Hoạt động</option>
                                                    <option value="off">Tạm tắt</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- FOOTER -->
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i>Đóng
                                        </button>
                                        <button type="submit" class="btn btn-primary fw-semibold">
                                            <i class="fas fa-save me-1"></i>Lưu gói Hosting
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
					
					<!-- ========== MODAL SỬA GÓI HOSTING ========== -->
					<div class="modal fade" id="editPackageModal" tabindex="-1" aria-labelledby="editPackageModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg modal-dialog-centered">
							<div class="modal-content border-0 shadow-lg rounded-3">
							<div class="modal-header bg-warning text-white">
								<h5 class="modal-title fw-semibold" id="editPackageModalLabel">
								<i class="fas fa-pen-to-square me-2"></i>Chỉnh sửa gói Hosting
								</h5>
								<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
							</div>

							<form id="editPackageForm" method="POST">
								<input type="hidden" name="id" id="edit_id">
								<div class="modal-body p-4">
								<div class="row g-3">
									<div class="col-md-6">
									<label class="form-label fw-semibold">Tên gói</label>
									<input type="text" class="form-control" name="name_host" id="edit_name_host" required>
									</div>
									<div class="col-md-6">
									<label class="form-label fw-semibold">Server host</label>
									<input type="text" class="form-control" name="server_host" id="edit_server_host" required>
									</div>
									<div class="col-md-6">
									<label class="form-label fw-semibold">Giá tiền (VNĐ)</label>
									<input type="number" class="form-control" name="money" id="edit_money" min="1000" required>
									</div>
									<div class="col-md-6">
									<label class="form-label fw-semibold">Dung lượng (MB)</label>
									<input type="number" class="form-control" name="disk" id="edit_disk" min="100" required>
									</div>
									<div class="col-md-6">
									<label class="form-label fw-semibold">Số domain khác</label>
									<input type="text" class="form-control" name="other_domain" id="edit_other_domain">
									</div>
									<div class="col-md-6">
									<label class="form-label fw-semibold">Alias Domain</label>
									<input type="text" class="form-control" name="alias_domain" id="edit_alias_domain">
									</div>
									<div class="col-md-6">
									<label class="form-label fw-semibold">Trạng thái</label>
									<select class="form-select" name="status" id="edit_status">
										<option value="on">Hoạt động</option>
										<option value="off">Tạm tắt</option>
									</select>
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

					<script>
						"use strict";
						document.addEventListener("DOMContentLoaded", () => {
							// ============================
							// 🔧 CẤU HÌNH CƠ BẢN
							// ============================
							const apiUrl = "/ajax/admin/package/package_hosting.php";
							const TOTAL_PAGES = <?= (int)$total_pages ?>;
							const CURRENT_PAGE = <?= (int)$page ?>;
							const paginationLinks = document.querySelectorAll(".pagination .page-link");
							const tableBody = document.getElementById("packageTableBody");
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
                                name: document.getElementById("filterNameHost"),
                                server: document.getElementById("filterServerHost"),
                                status: document.getElementById("filterStatus"),
                                sortMoney: document.getElementById("sortMoney"),
                                reset: document.getElementById("resetFilter"),
                                limit: document.getElementById("limitSelect"),
                                sort: document.getElementById("sortSelect"),
                            };

                            function applyFilter() {
                                const idVal = filterEls.id?.value.trim().toLowerCase() || "";
                                const nameVal = filterEls.name?.value.trim().toLowerCase() || "";
                                const serverVal = filterEls.server?.value.trim().toLowerCase() || "";
                                const statusVal = filterEls.status?.value.trim() || "";
                                const sortMoneyVal = filterEls.sortMoney?.value || "";

                                let filtered = originalRows.filter(tr => {
                                    const tds = tr.querySelectorAll("td");
                                    if (tds.length < 9) return false;

                                    const id = tds[0].innerText.toLowerCase();
                                    const name = tds[1].innerText.toLowerCase();
                                    const server = tds[3].innerText.toLowerCase();
                                    const money = parseFloat(tds[4].innerText.replace(/[^\d]/g, "")) || 0;
                                    const status = tr.querySelector(".toggle-status")?.checked ? "on" : "off";

                                    return (
                                        (!idVal || id.includes(idVal)) &&
                                        (!nameVal || name.includes(nameVal)) &&
                                        (!serverVal || server.includes(serverVal)) &&
                                        (!statusVal || status === statusVal)
                                    );
                                });

                                // 🔄 Sắp xếp giá tiền
                                if (sortMoneyVal === "asc") {
                                    filtered.sort((a, b) => {
                                        const moneyA = parseFloat(a.querySelectorAll("td")[4].innerText.replace(/[^\d]/g, "")) || 0;
                                        const moneyB = parseFloat(b.querySelectorAll("td")[4].innerText.replace(/[^\d]/g, "")) || 0;
                                        return moneyA - moneyB;
                                    });
                                } else if (sortMoneyVal === "desc") {
                                    filtered.sort((a, b) => {
                                        const moneyA = parseFloat(a.querySelectorAll("td")[4].innerText.replace(/[^\d]/g, "")) || 0;
                                        const moneyB = parseFloat(b.querySelectorAll("td")[4].innerText.replace(/[^\d]/g, "")) || 0;
                                        return moneyB - moneyA;
                                    });
                                }

                                tableBody.innerHTML = filtered.length
                                    ? filtered.map(tr => tr.outerHTML).join("")
                                    : `<tr><td colspan="10" class="text-center text-muted py-3">Không tìm thấy kết quả phù hợp</td></tr>`;
                            }

                            // Gắn sự kiện cho tất cả filter input/select
                            Object.values(filterEls).forEach(el => {
                                if (el && ["INPUT", "SELECT"].includes(el.tagName))
                                    el.addEventListener("input", applyFilter);
                            });

                            // 🧹 Nút reset lọc
                            filterEls.reset?.addEventListener("click", e => {
                                e.preventDefault();

                                // Xóa toàn bộ giá trị filter
                                ["id", "name", "server", "status", "sortMoney"].forEach(key => {
                                    if (filterEls[key]) filterEls[key].value = "";
                                });

                                if (filterEls.limit) filterEls.limit.value = "10";
                                if (filterEls.sort) filterEls.sort.value = "asc";

                                // Reset lại bảng dữ liệu gốc
                                tableBody.innerHTML = originalRows.map(tr => tr.outerHTML).join("");

                                // Reload trang để reset URL params
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
							// 🟢 THÊM GÓI HOSTING (AJAX)
							// ============================
							const addPackageForm = document.getElementById("addPackageForm");
							addPackageForm?.addEventListener("submit", e => {
								e.preventDefault();
								const formData = new FormData(addPackageForm);
								formData.append("action", "ADD_PACKAGE_HOSTING");
								Swal.fire({ title: "Đang xử lý...", icon: "info", showConfirmButton: false, didOpen: () => Swal.showLoading() });
								fetch(apiUrl, { method: "POST", body: formData })
								.then(res => res.json())
								.then(data => {
									Swal.close();
									if (data.status === "success")
									showAlert3("success", "Thành công!", data.msg, 2500, () => {
										bootstrap.Modal.getInstance(document.getElementById("addPackageHostingModal"))?.hide();
										addPackageForm.reset();
										window.location.reload();
									});
									else showAlert3("error", "Lỗi!", data.msg || "Không thể thêm gói hosting.", 3000);
								})
								.catch(() => {
									Swal.close();
									showAlert3("error", "Lỗi kết nối!", "Không thể kết nối tới máy chủ.", 3000);
								});
							});
							
							// ============================ HIỂN THỊ MODAL SỬA ============================
							document.addEventListener("click", e => {
							const btn = e.target.closest(".btn-edit");
							if (!btn) return;

							const detail = JSON.parse(btn.dataset.detail || "{}");
							const modalEl = document.getElementById("editPackageModal");
							const modal = new bootstrap.Modal(modalEl);

							// 🧩 Đổ dữ liệu vào form
							document.getElementById("edit_id").value = detail.id || "";
							document.getElementById("edit_name_host").value = detail.name_host || "";
							document.getElementById("edit_server_host").value = detail.server_host || "";
							document.getElementById("edit_money").value = detail.money || "";
							document.getElementById("edit_disk").value = detail.disk || "";
							document.getElementById("edit_other_domain").value = detail.other_domain || "";
							document.getElementById("edit_alias_domain").value = detail.alias_domain || "";
							document.getElementById("edit_status").value = detail.status || "off";

							modal.show();
							});

							// ============================ GỬI AJAX CẬP NHẬT ============================
							document.getElementById("editPackageForm")?.addEventListener("submit", async e => {
							e.preventDefault();
							const form = e.target;
							const formData = new FormData(form);
							formData.append("action", "UPDATE_PACKAGE_HOSTING");

							Swal.fire({
								title: "Đang cập nhật...",
								icon: "info",
								showConfirmButton: false,
								allowOutsideClick: false,
								didOpen: () => Swal.showLoading()
							});

							try {
								const res = await fetch(apiUrl, { method: "POST", body: formData });
								const data = await res.json();
								Swal.close();

								if (data.status === "success") {
								showAlert3("success", "Thành công!", data.msg || "Cập nhật gói hosting thành công!", 2000, () => {
									location.reload();
								});
								bootstrap.Modal.getInstance(document.getElementById("editPackageModal"))?.hide();
								} else {
								showAlert3("error", "Lỗi!", data.msg || "Không thể cập nhật gói hosting!", 3000);
								}
							} catch (err) {
								Swal.close();
								showAlert3("error", "Lỗi kết nối!", "Không thể gửi yêu cầu tới máy chủ.", 3000);
							}
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
								formData.append("action", "UPDATE_PACKAGE_HOSTING_STATUS");
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
                                    const name = btn.dataset.name || "Không rõ";
                                    if (!id) return;

                                    Swal.fire({
                                        title: "Xác nhận xóa gói hosting",
                                        html: `
                                            <div class="fw-semibold text-danger mb-2">
                                                Bạn có chắc chắn muốn xóa gói này?
                                            </div>
                                            <div class="border rounded p-2 bg-light text-start">
                                                <b>ID:</b> <span class="text-primary">#${id}</span><br>
                                                <b>Tên gói:</b> <span class="text-success">${name}</span>
                                            </div>
                                            <small class="text-muted d-block mt-2">Hành động này không thể hoàn tác.</small>
                                        `,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonText: "Xóa ngay",
                                        cancelButtonText: "Hủy",
                                        confirmButtonColor: "#dc3545",
                                        cancelButtonColor: "#6c757d",
                                        reverseButtons: true,
                                    }).then(result => {
                                        if (!result.isConfirmed) return;

                                        Swal.fire({
                                            title: "Đang xóa...",
                                            icon: "info",
                                            showConfirmButton: false,
                                            allowOutsideClick: false,
                                            didOpen: () => Swal.showLoading()
                                        });

                                        const formData = new FormData();
                                        formData.append("action", "DELETE_PACKAGE_HOSTING");
                                        formData.append("id", id);

                                        fetch(apiUrl, { method: "POST", body: formData })
                                            .then(res => res.json())
                                            .then(data => {
                                                Swal.close();
                                                if (data.status === "success") {
                                                    showAlert3("success", "Thành công!", data.msg || "Đã xóa gói hosting.", 1800, () => {
                                                        btn.closest("tr")?.remove();
                                                    });
                                                } else {
                                                    showAlert3("error", "Lỗi!", data.msg || "Không thể xóa gói hosting này.", 2500);
                                                }
                                            })
                                            .catch(() => {
                                                Swal.close();
                                                showAlert3("error", "Lỗi kết nối!", "Không thể kết nối tới máy chủ.", 2500);
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


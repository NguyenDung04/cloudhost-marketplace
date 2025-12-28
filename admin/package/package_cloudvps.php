<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Quản lý gói VPS";
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
					$total_records = $ketnoi->num_rows("SELECT * FROM `package_cloudvps`");
					
					// Tổng số trang
					$total_pages = ceil($total_records / $limit);
					
					// Lấy dữ liệu theo trang + sắp xếp
					$rows = $ketnoi->get_list("SELECT * FROM `package_cloudvps` $orderBy LIMIT $offset, $limit");
					
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
					</div>
					<!-- ================= FILTER FORM ================= -->
					<div class="card-body">
						<form id="filterCloudVPS" class="row g-3 align-items-center flex-wrap justify-content-between">
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-hashtag text-primary"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterId" placeholder="Nhập ID">
								</div>
							</div>
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-university text-success"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterNameCVPS" placeholder="Nhập tên gói">
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
                            <table class="table table-striped mb-0 align-middle">
                                <thead class="table-light text-uppercase fw-semibold text-secondary">
                                    <tr>
                                        <th><i class="fas fa-hashtag me-1 text-muted"></i>ID</th>
                                        <th><i class="fas fa-box me-1 text-primary"></i>Tên gói</th>
                                        <th><i class="fas fa-toggle-on me-1 text-info"></i>Trạng thái</th>
                                        <th><i class="fas fa-calendar-plus me-1 text-success"></i>Ngày tạo</th>
                                        <th><i class="fas fa-calendar-check me-1 text-warning"></i>Ngày sửa</th>
                                        <th class="text-center">
                                            <i class="fas fa-cogs me-1 text-secondary"></i>Hành động
                                        </th>
                                    </tr>
                                </thead>

                                <tbody id="cloudVpsTableBody">
                                    <?php if (!empty($rows)): ?>
                                    <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <!-- ID -->
                                        <td class="fw-bold"><?= $row['id'] ?></td>

                                        <!-- NAME -->
                                        <td class="fw-semibold text-primary"><?= ($row['name']) ?></td>

                                        <!-- STATUS -->
										<td class="text-start">
											<div class="form-check form-switch">
												<input class="form-check-input toggle-status" 
													type="checkbox" 
													data-id="<?= $row['id'] ?>"
													<?= $row['status'] === 'on' ? 'checked' : '' ?>>
											</div>
										</td> 

                                        <!-- CREATED -->
                                        <td class="text-success fw-semibold">
                                            <?= fmDate($row['created_at']) ?>
                                        </td>

                                        <!-- UPDATED -->
                                        <td class="text-warning fw-semibold">
                                            <?= fmDate($row['updated_at']) ?>
                                        </td>

                                        <!-- ACTION -->
                                        <td class="text-center">
                                            <button 
                                                class="btn btn-outline-primary btn-sm btn-edit"
                                                data-id="<?= $row['id'] ?>"
                                                data-name="<?= htmlspecialchars($row['name'], ENT_QUOTES) ?>"
                                                data-detail='<?= htmlspecialchars($row['detail'], ENT_QUOTES) ?>'
                                                data-pricing='<?= htmlspecialchars($row['pricing'], ENT_QUOTES) ?>'
                                                data-price='<?= htmlspecialchars($row['price'], ENT_QUOTES) ?>'
                                                data-status="<?= $row['status'] ?>"
                                            >
                                                <i class="fas fa-pen-to-square me-1"></i> Sửa
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">
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
				<div class="modal fade" id="addonCompareModal" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Cập nhật giá Gói VPS</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>

						<div class="modal-body">
							<table class="table table-bordered text-center align-middle">
							<thead class="table-light">
								<tr>
								<th>Chu kỳ</th>
								<th>Giá gốc</th>
								<th>Giá bán</th>
								</tr>
							</thead>
							<tbody id="compareTableBody"></tbody>
							</table>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-primary" id="btnSaveChange">💾 Lưu thay đổi</button>
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
						</div>
						</div>
					</div>
				</div>
				<?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
			</div>
		</div>
		<script>
			"use strict";
			document.addEventListener("DOMContentLoaded", () => {
				// ============================
				// ⚙️ QUẢN LÝ MODAL SỬA MODAL PACKAGE CLOUD VPS
				// ============================
				const editButtons = document.querySelectorAll(".btn-edit");
				const modalEl = document.getElementById("addonCompareModal");
				const modal = modalEl ? new bootstrap.Modal(modalEl) : null;
				const compareTable = document.getElementById("compareTableBody");
				const saveBtn = document.getElementById("btnSaveChange");
				const apiUrl = "/ajax/admin/package/package_cloudvps.php";

				let currentAddonId = null;
				let currentPriceData = {};

				editButtons.forEach(btn => {
					btn.addEventListener("click", () => {
						currentAddonId = btn.dataset.id;
						const detailRaw = btn.dataset.detail;
						const priceRaw  = btn.dataset.price;

						try {
							const detail = JSON.parse(detailRaw);
							const price  = JSON.parse(priceRaw);
							renderCompare(detail, price);
							modal?.show();
						} catch (err) {
							console.error("❌ Lỗi parse JSON:", err);
							showAlert3("error", "Lỗi dữ liệu", "Dữ liệu JSON không hợp lệ!");
						}
					});
				});

				function renderCompare(detail, price) {
					const d = Array.isArray(detail) ? detail[0] : detail;
					const p = Array.isArray(price) ? price[0] : price;

					const pricingDetail = d?.pricing ?? {};
					const pricingPrice  = p ?? {};
					currentPriceData = structuredClone(pricingPrice);

					let html = "";
					const allKeys = new Set([...Object.keys(pricingDetail), ...Object.keys(pricingPrice)]);

					allKeys.forEach(key => {
						const dItem = pricingDetail[key] || {};
						const pItem = pricingPrice[key] || {};
						html += `
							<tr data-cycle="${key}">
								<td>${dItem.billing_cycle || pItem.billing_cycle || "-"}</td>
								<td>${dItem.amount ? dItem.amount.toLocaleString("vi-VN") + " đ" : "-"}</td>
								<td>
									<input type="number"
										class="form-control form-control-sm text-end"
										value="${pItem.amount ?? 0}"
										min="0" step="1000">
								</td>
							</tr>`;
					});
					compareTable.innerHTML = html;
				}

				if (saveBtn) {
					saveBtn.addEventListener("click", async () => {
						if (!currentAddonId) return showAlert3("error", "Lỗi", "Không xác định được ID addon!");

						const rows = compareTable.querySelectorAll("tr");
						rows.forEach(row => {
							const key = row.dataset.cycle;
							const input = row.querySelector("input");
							const newValue = parseInt(input.value) || 0;
							if (!currentPriceData[key]) currentPriceData[key] = {};
							currentPriceData[key].amount = newValue;
						});

						console.log("📦 Gửi dữ liệu:", currentPriceData);

						try {
							const res = await fetch(apiUrl, {
								method: "POST",
								headers: { "Content-Type": "application/x-www-form-urlencoded" },
								body: new URLSearchParams({
									action: "UPDATE_PCVPS_PRICE",
									id: currentAddonId,
									price: JSON.stringify(currentPriceData)
								})
							});
							const data = await res.json();
							if (data.status === "success") {
								showAlert3("success", "Thành công", data.message || "Cập nhật giá thành công!", 2000, () => {
									modal?.hide();
									setTimeout(() => location.reload(), 800);
								});
							} else showAlert3("error", "Lỗi", data.message || "Không thể cập nhật giá!");
						} catch (err) {
							console.error(err);
							showAlert3("error", "Kết nối thất bại", "Không thể gửi dữ liệu lên máy chủ!");
						}
					});
				}

				// ============================
				// 🔁 CẬP NHẬT TRẠNG THÁI (KHÔNG RELOAD)
				// ============================
				document.querySelectorAll(".toggle-status").forEach(toggle => {
					toggle.addEventListener("change", function () {
					const id = this.dataset.id;
					const newStatus = this.checked ? "on" : "off";
					this.disabled = true;
					const formData = new FormData();
					formData.append("action", "UPDATE_PCVPS_STATUS");
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
                // 🔍 LỌC DỮ LIỆU CLIENT-SIDE
                // ============================
                const tableBody = document.getElementById("cloudVpsTableBody");
                if (!tableBody) return;

                const originalRows = Array.from(tableBody.querySelectorAll("tr")).map(tr => tr.cloneNode(true));

                const filterId = document.getElementById("filterId");
                const filterNameCVPS = document.getElementById("filterNameCVPS");
                const resetFilter = document.getElementById("resetFilter");
                const limitSelect = document.getElementById("limitSelect");
                const sortSelect = document.getElementById("sortSelect");

                function applyFilter() {
                    const idVal = filterId?.value.trim().toLowerCase() || "";
                    const nameVal = filterNameCVPS?.value.trim().toLowerCase() || "";

                    tableBody.innerHTML = "";

                    const filtered = originalRows.filter(tr => {
                        const tds = tr.querySelectorAll("td");
                        if (tds.length < 3) return false;

                        const id = tds[0].innerText.toLowerCase();
                        const name = tds[2].innerText.toLowerCase(); // ✔ ĐÚNG TÊN GÓI

                        return (
                            (!idVal || id.includes(idVal)) &&
                            (!nameVal || name.includes(nameVal))
                        );
                    });

                    if (filtered.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="12" class="text-center text-muted">Không tìm thấy kết quả phù hợp</td></tr>`;
                    } else {
                        filtered.forEach(tr => tableBody.appendChild(tr.cloneNode(true)));
                    }
                }

                [filterId, filterNameCVPS].forEach(input => {
                    input?.addEventListener("input", applyFilter);
                    input?.addEventListener("change", applyFilter);
                });

                // RESET FILTER
                resetFilter?.addEventListener("click", e => {
                    e.preventDefault();

                    filterId.value = "";
                    filterNameCVPS.value = "";

                    limitSelect.value = "10";
                    sortSelect.value = "asc";

                    tableBody.innerHTML = "";
                    originalRows.forEach(tr => tableBody.appendChild(tr.cloneNode(true)));

                    // Load lại trang để đồng bộ param
                    window.location.href = window.location.pathname;
                });

			});
		</script>

		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?> 
	</body>
</html>
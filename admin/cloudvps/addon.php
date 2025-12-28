<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Addon VPS";
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
					$total_records = $ketnoi->num_rows("SELECT * FROM `addon_vps`");
					
					// Tổng số trang
					$total_pages = ceil($total_records / $limit);
					
					// Lấy dữ liệu theo trang + sắp xếp
					$rows = $ketnoi->get_list("SELECT * FROM `addon_vps` $orderBy LIMIT $offset, $limit");
					
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
						<form id="filterAddonForm" class="row g-3 align-items-center flex-wrap justify-content-between">
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-hashtag text-primary"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterId" placeholder="Nhập ID">
								</div>
							</div>
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-university text-success"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterAddonName" placeholder="Nhập tên gói">
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
									<tr class="align-middle text-uppercase fw-semibold text-secondary">
										<th><i class="fas fa-hashtag text-muted me-1"></i> ID</th>
										<th><i class="fas fa-box text-primary me-1"></i> TÊN GÓI</th>
										<th><i class="fas fa-calendar-check text-primary me-1"></i> NGÀY CẬP NHẬT</th>
										<th class="text-center">
											<i class="fas fa-cogs text-warning me-1"></i> HÀNH ĐỘNG
										</th>
									</tr>
								</thead>
								<!-- ================== BẢNG DỮ LIỆU ================== -->
								<tbody id="addonTableBody">
									<?php if (count($rows) > 0): ?>
									<?php foreach ($rows as $row): ?>
									<tr>
										<td><?= $row['id'] ?></td>
										<td class="fw-semibold text-primary"><?= ($row['name']) ?></td>
										<td><span class="text-primary"><?= fmDate($row['updated_at']) ?></span></td>
										<td class="text-center">
											<button 
												class="btn btn-outline-primary btn-sm me-1 btn-edit"
												data-id="<?= $row['id'] ?>"
												data-detail='<?= htmlspecialchars($row['detail'], ENT_QUOTES) ?>'
												data-price='<?= htmlspecialchars($row['price'], ENT_QUOTES) ?>'
												>
											<i class="fas fa-pen-to-square me-1"></i> Sửa
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
							<h5 class="modal-title">Cập nhật giá Addon VPS</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>

						<div class="modal-body">
							<table class="table table-bordered text-center align-middle">
							<thead class="table-light">
								<tr>
								<th>Chu kỳ</th>
								<th>Detail (amount)</th>
								<th>Price (amount)</th>
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
				<script>
					"use strict";
					document.addEventListener("DOMContentLoaded", () => {
						console.log("✅ JS Quản lý Addon VPS đã khởi động");

						// ============================
						// ⚙️ QUẢN LÝ MODAL ADDON VPS
						// ============================
						const editButtons = document.querySelectorAll(".btn-edit");
						const modalEl = document.getElementById("addonCompareModal");
						const modal = modalEl ? new bootstrap.Modal(modalEl) : null;
						const compareTable = document.getElementById("compareTableBody");
						const saveBtn = document.getElementById("btnSaveChange");

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
									const res = await fetch("/ajax/admin/cloudvps/addon.php", {
										method: "POST",
										headers: { "Content-Type": "application/x-www-form-urlencoded" },
										body: new URLSearchParams({
											action: "UPDATE_ADDON_PRICE",
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
						// 🔍 LỌC DỮ LIỆU CLIENT-SIDE
						// ============================
						const tableBody = document.getElementById("addonTableBody");
						if (!tableBody) return;

						const originalRows = Array.from(tableBody.querySelectorAll("tr")).map(tr => tr.cloneNode(true));
						const filterId = document.getElementById("filterId");
						const filterAddonName = document.getElementById("filterAddonName");
						const resetFilter = document.getElementById("resetFilter");
						const limitSelect = document.getElementById("limitSelect");
						const sortSelect = document.getElementById("sortSelect");

						const TOTAL_PAGES = window.TOTAL_PAGES ?? <?= (int)$total_pages ?>;
						const CURRENT_PAGE = window.CURRENT_PAGE ?? <?= (int)$page ?>;
						const paginationLinks = document.querySelectorAll(".pagination .page-link");

						function goToPage(newPage) {
							newPage = Math.max(1, Math.min(newPage, TOTAL_PAGES));
							const params = new URLSearchParams(window.location.search);
							params.set("page", newPage);
							params.set("limit", limitSelect?.value || "10");
							params.set("sort", sortSelect?.value || "asc");
							window.location.href = window.location.pathname + "?" + params.toString();
						}

						function updatePaginationButtons() {
							paginationLinks.forEach(link => {
								const li = link.closest(".page-item");
								const action = link.dataset.action;
								const isFirstOrPrev = ["first", "prev"].includes(action);
								const isNextOrLast = ["next", "last"].includes(action);
								li.classList.remove("disabled");

								if ((isFirstOrPrev && CURRENT_PAGE === 1) || (isNextOrLast && CURRENT_PAGE === TOTAL_PAGES)) {
									li.classList.add("disabled");
									link.setAttribute("aria-disabled", "true");
									link.setAttribute("tabindex", "-1");
								} else {
									link.removeAttribute("aria-disabled");
									link.removeAttribute("tabindex");
								}
							});
						}
						updatePaginationButtons();

						paginationLinks.forEach(link => {
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
										const text = parseInt(link.textContent.trim());
										if (!isNaN(text)) newPage = text;
								}
								goToPage(newPage);
							});
						});

						function applyFilter() {
							const idVal = filterId?.value.trim().toLowerCase() || "";
							const nameVal = filterAddonName?.value.trim().toLowerCase() || "";

							tableBody.innerHTML = "";
							const filtered = originalRows.filter(tr => {
								const tds = tr.querySelectorAll("td");
								if (tds.length < 2) return false;
								const id = tds[0].innerText.toLowerCase();
								const name = tds[1].innerText.toLowerCase();
								return (!idVal || id.includes(idVal)) && (!nameVal || name.includes(nameVal));
							});

							if (filtered.length === 0)
								tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Không tìm thấy kết quả phù hợp</td></tr>`;
							else
								filtered.forEach(tr => tableBody.appendChild(tr.cloneNode(true)));
						}

						[filterId, filterAddonName].forEach(input => {
							input?.addEventListener("input", applyFilter);
							input?.addEventListener("change", applyFilter);
						});

						resetFilter?.addEventListener("click", e => {
							e.preventDefault();
							if (filterId) filterId.value = "";
							if (filterAddonName) filterAddonName.value = "";
							if (limitSelect) limitSelect.value = "10";
							if (sortSelect) sortSelect.value = "asc";
							tableBody.innerHTML = "";
							originalRows.forEach(tr => tableBody.appendChild(tr.cloneNode(true)));
							window.location.href = window.location.origin + window.location.pathname;
						});
					});
				</script>
				<?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
			</div>
		</div>
		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?> 
	</body>
</html>
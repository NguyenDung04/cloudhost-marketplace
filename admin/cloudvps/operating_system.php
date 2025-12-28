<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Quản lý hệ điều hành";
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
					$total_records = $ketnoi->num_rows("SELECT * FROM `img_os`");
					
					// Tổng số trang
					$total_pages = ceil($total_records / $limit);
					
					// Lấy dữ liệu theo trang + sắp xếp
					$rows = $ketnoi->get_list("SELECT * FROM `img_os` $orderBy LIMIT $offset, $limit");
					
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
						<form id="filterOperatingSystemForm" class="row g-3 align-items-center flex-wrap justify-content-between">
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-hashtag text-primary"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterId" placeholder="ID Hệ điều hành">
								</div>
							</div>
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-university text-success"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterOperatingSystemName" placeholder="Tên hệ điều hành">
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
										<th><i class="fas fa-desktop text-primary me-1"></i> TÊN HỆ ĐIỀU HÀNH</th>
										<th><i class="fas fa-image text-info me-1"></i> ẢNH HỆ ĐIỀU HÀNH</th>
										<th><i class="fas fa-calendar-plus text-success me-1"></i> NGÀY TẠO</th>
										<th><i class="fas fa-calendar-check text-success me-1"></i> NGÀY CẬP NHẬT</th>
										<th class="text-center">
											<i class="fas fa-tools text-warning me-1"></i> HÀNH ĐỘNG
										</th>
									</tr>
								</thead>
								<!-- ================== BẢNG DỮ LIỆU ================== -->
								<tbody id="operatingSystemTableBody">
									<?php if (count($rows) > 0): ?>
									<?php foreach ($rows as $row): ?>
									<tr>
										<td><?= $row['id'] ?></td>
										<td class="fw-semibold text-primary"><?= ($row['os_name']) ?></td>
										<td>
											<img src="<?=$row['image_url'];?>" alt="<?=$row['os_name'];?>" height="40">
										</td>
										<td><span class="text-primary"><?= fmDate($row['created_at']) ?></span></td>
										<td><span class="text-primary"><?= fmDate($row['updated_at']) ?></span></td>
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
				<!-- ===================================================
					🟦 MODAL: CẬP NHẬT HỆ ĐIỀU HÀNH
					=================================================== -->
				<div class="modal fade" id="editOperatingSystemModal" tabindex="-1" aria-labelledby="editOperatingSystemLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-lg">
						<div class="modal-content shadow-lg border-0 rounded-4">
							<div class="modal-header bg-primary text-white">
								<h5 class="modal-title fw-semibold" id="editOperatingSystemLabel">
									<i class="fas fa-pen-to-square me-2"></i> Cập nhật hệ điều hành
								</h5>
								<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<form id="editOperatingSystemForm" enctype="multipart/form-data">
								<div class="modal-body">
									<input type="hidden" name="id" id="editOsId">
									<div class="mb-3">
										<label for="editOsName" class="form-label fw-semibold">Tên hệ điều hành</label>
										<input type="text" name="os_name" id="editOsName" class="form-control" required>
									</div>
									<div class="mb-3">
										<label class="form-label fw-semibold">Ảnh hiện tại</label>
										<div id="currentOsImage" class="border rounded p-2 text-center bg-light">
											<img src="" id="previewCurrentImage" alt="Ảnh hiện tại" height="80" class="rounded shadow-sm">
										</div>
									</div>
									<div class="mb-3">
										<label for="editOsImage" class="form-label fw-semibold">Chọn ảnh mới (nếu muốn thay)</label>
										<input type="file" name="os_image" id="editOsImage" accept="image/*" class="form-control">
									</div>
								</div>
								<div class="modal-footer bg-light">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
									<i class="fas fa-times me-1"></i> Hủy
									</button>
									<button type="submit" class="btn btn-primary fw-semibold">
									<i class="fas fa-save me-1"></i> Lưu thay đổi
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- ===================================================
					🟥 MODAL: XÓA HỆ ĐIỀU HÀNH
					=================================================== -->
				<div class="modal fade" id="deleteOperatingSystemModal" tabindex="-1" aria-labelledby="deleteOperatingSystemLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content shadow-lg border-0 rounded-4">
							<div class="modal-header bg-danger text-white">
								<h5 class="modal-title fw-semibold" id="deleteOperatingSystemLabel">
									<i class="fas fa-trash-alt me-2"></i> Xác nhận xóa hệ điều hành
								</h5>
								<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<form id="deleteOperatingSystemForm">
								<div class="modal-body">
									<input type="hidden" name="id" id="deleteOsId">
									<p class="mb-2">Bạn có chắc muốn xóa hệ điều hành sau?</p>
									<div class="alert alert-warning mb-0 py-2 px-3 border-warning">
										<strong>ID:</strong> <span id="deleteOsIdText" class="text-danger fw-bold"></span><br>
										<strong>Tên hệ điều hành:</strong> <span id="deleteOsNameText" class="text-primary fw-bold"></span>
									</div>
								</div>
								<div class="modal-footer bg-light">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
									<i class="fas fa-times me-1"></i> Hủy
									</button>
									<button type="submit" class="btn btn-danger fw-semibold">
									<i class="fas fa-trash-alt me-1"></i> Xóa ngay
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
						// 🔍 LỌC DỮ LIỆU CLIENT-SIDE
						// ============================
						const tableBody = document.getElementById("operatingSystemTableBody");
						const originalRows = Array.from(tableBody.querySelectorAll("tr")).map(tr => tr.cloneNode(true));

						const filterId = document.getElementById("filterId");
						const filterOperatingSystemName = document.getElementById("filterOperatingSystemName");
						const resetFilter = document.getElementById("resetFilter");
						const limitSelect = document.getElementById("limitSelect");
						const sortSelect = document.getElementById("sortSelect");

						const TOTAL_PAGES = <?= (int)$total_pages ?>;
						const CURRENT_PAGE = <?= (int)$page ?>;
						const paginationLinks = document.querySelectorAll(".pagination .page-link");
						const apiUrl = "/ajax/admin/cloudvps/operating_system.php";

						function goToPage(newPage) {
							newPage = Math.max(1, Math.min(newPage, TOTAL_PAGES));
							const params = new URLSearchParams(window.location.search);
							params.set("page", newPage);
							params.set("limit", limitSelect.value);
							params.set("sort", sortSelect.value);
							window.location.href = window.location.pathname + "?" + params.toString();
						}

						function updatePaginationButtons() {
							paginationLinks.forEach(link => {
								const action = link.dataset.action;
								const li = link.closest(".page-item");
								li.classList.remove("disabled");
								const isFirstOrPrev = action === "first" || action === "prev";
								const isNextOrLast = action === "next" || action === "last";
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
										const text = parseInt(link.textContent.trim());
										if (!isNaN(text)) newPage = text;
								}
								goToPage(newPage);
							});
						});
						updatePaginationButtons();

						function applyFilter() {
							const idVal = filterId.value.trim().toLowerCase();
							const osNameVal = filterOperatingSystemName.value.trim().toLowerCase();
							tableBody.innerHTML = "";
							const filtered = originalRows.filter(tr => {
								const tds = tr.querySelectorAll("td");
								if (tds.length < 5) return false;
								const id = tds[0].innerText.toLowerCase();
								const osName = tds[1].innerText.toLowerCase();
								return (!idVal || id.includes(idVal)) && (!osNameVal || osName.includes(osNameVal));
							});
							if (filtered.length === 0)
								tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Không tìm thấy kết quả phù hợp</td></tr>`;
							else filtered.forEach(tr => tableBody.appendChild(tr.cloneNode(true)));
						}

						[filterId, filterOperatingSystemName].forEach(input => {
							input.addEventListener("input", applyFilter);
							input.addEventListener("change", applyFilter);
						});

						resetFilter.addEventListener("click", e => {
							e.preventDefault();
							filterId.value = "";
							filterOperatingSystemName.value = "";
							if (limitSelect) limitSelect.value = "10";
							if (sortSelect) sortSelect.value = "asc";
							tableBody.innerHTML = "";
							originalRows.forEach(tr => tableBody.appendChild(tr.cloneNode(true)));
							window.location.href = window.location.origin + window.location.pathname;
						});

						// ✏️ MỞ MODAL CẬP NHẬT OS
						document.querySelectorAll(".btn-edit").forEach(btn => {
							btn.addEventListener("click", function () {
								const row = this.closest("tr");
								const id = this.dataset.id;
								const osName = row.querySelector("td:nth-child(2)").innerText.trim();
								const imgSrc = row.querySelector("td:nth-child(3) img").src;
								document.getElementById("editOsId").value = id;
								document.getElementById("editOsName").value = osName;
								document.getElementById("previewCurrentImage").src = imgSrc;
								new bootstrap.Modal(document.getElementById("editOperatingSystemModal")).show();
							});
						});

						// 🧾 CẬP NHẬT OS (AJAX)
						const editForm = document.getElementById("editOperatingSystemForm");
						if (editForm)
							editForm.addEventListener("submit", e => {
								e.preventDefault();
								const formData = new FormData(editForm);
								formData.append("action", "UPDATE_OS");
								Swal.fire({ title: "Đang cập nhật...", text: "Vui lòng chờ", icon: "info", showConfirmButton: false, didOpen: () => Swal.showLoading() });
								fetch(apiUrl, { method: "POST", body: formData })
									.then(res => res.json())
									.then(data => {
										Swal.close();
										if (data.status === "success")
											showAlert3("success", "Thành công!", data.msg, 2500, () => {
												bootstrap.Modal.getInstance(document.getElementById("editOperatingSystemModal")).hide();
												editForm.reset();
												window.location.reload();
											});
										else showAlert3("error", "Lỗi!", data.msg || "Không thể cập nhật", 3000);
									})
									.catch(err => {
										console.error(err);
										Swal.close();
										showAlert3("error", "Lỗi kết nối!", "Không thể kết nối tới máy chủ", 3000);
									});
							});

						
							// 🗑️ XÓA OS (AJAX)
						const deleteForm = document.getElementById("deleteOperatingSystemForm");
						if (deleteForm)
							deleteForm.addEventListener("submit", e => {
								e.preventDefault();
								const formData = new FormData(deleteForm);
								formData.append("action", "DELETE_OS");
								Swal.fire({ title: "Đang xóa...", text: "Vui lòng chờ", icon: "info", showConfirmButton: false, didOpen: () => Swal.showLoading() });
								fetch(apiUrl, { method: "POST", body: formData })
									.then(res => res.json())
									.then(data => {
										Swal.close();
										if (data.status === "success")
											showAlert3("success", "Thành công!", data.msg, 2500, () => {
												bootstrap.Modal.getInstance(document.getElementById("deleteOperatingSystemModal")).hide();
												window.location.reload();
											});
										else showAlert3("error", "Lỗi!", data.msg || "Không thể xóa.", 3000);
									})
									.catch(err => {
										console.error(err);
										Swal.close();
										showAlert3("error", "Lỗi kết nối!", "Không thể kết nối tới máy chủ", 3000);
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
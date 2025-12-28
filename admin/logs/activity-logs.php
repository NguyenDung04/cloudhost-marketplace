<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Nhật ký hoạt động";
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
							<!--end page-title-box-->
						</div>
						<!--end col-->
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
						$total_records = $ketnoi->num_rows("SELECT * FROM `his_login`");
						
						// Tổng số trang
						$total_pages = ceil($total_records / $limit);
						
						// Lấy dữ liệu theo trang + sắp xếp
						$rows = $ketnoi->get_list("SELECT * FROM `his_login` $orderBy LIMIT $offset, $limit");
						
						// Tính chỉ số hiển thị
						$from_record = $total_records > 0 ? $offset + 1 : 0;
						$to_record   = min($offset + $limit, $total_records);
						?>
					<div class="card" bis_skin_checked="1">
						<!-- ================= HEADER ================= -->
						<div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
							<h4 class="card-title mb-0 text-uppercase fw-semibold">
								<?php echo $title; ?>
							</h4>
						</div>
						<!--end card-header-->  
						<div class="card-body">
							<form id="logFilterForm" class="row g-3 align-items-center flex-wrap justify-content-between">
								<div class="col-auto flex-fill">
									<div class="input-group">
										<span class="input-group-text"><i class="fas fa-hashtag text-primary"></i></span>
										<input type="text" class="form-control py-2 fs-6" id="filterIdUser" placeholder="ID User">
									</div>
								</div>
								<div class="col-auto flex-fill">
									<div class="input-group">
										<span class="input-group-text"><i class="fas fa-user text-dark"></i></span>
										<input type="text" class="form-control py-2 fs-6" id="filterUsername" placeholder="Username">
									</div>
								</div>
								<div class="col-auto flex-fill">
									<div class="input-group">
										<span class="input-group-text"><i class="fas fa-network-wired text-danger"></i></span>
										<input type="text" class="form-control py-2 fs-6" id="filterIp" placeholder="Địa chỉ IP">
									</div>
								</div>
								<div class="col-auto flex-fill">
									<div class="input-group">
										<span class="input-group-text"><i class="fas fa-mobile-alt text-secondary"></i></span>
										<input type="text" class="form-control py-2 fs-6" id="filterDevice" placeholder="Thiết bị">
									</div>
								</div>
								<div class="col-auto flex-fill">
									<div class="input-group">
										<span class="input-group-text"><i class="far fa-clock text-primary"></i></span>
										<input type="date" class="form-control py-2 fs-6" id="filterTime">
									</div>
								</div>
								<div class="col-auto d-flex gap-2"> 
									<button type="reset" class="btn btn-danger px-4 py-2 fw-semibold" id="resetLogFilter">
									<i class="fas fa-trash-alt me-1"></i> Reset
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
						<div class="card-body pt-0" bis_skin_checked="1">
							<div class="table-responsive" bis_skin_checked="1">
								<table class="table table-striped mb-0">
									<thead class="table-light align-middle">
										<tr>
											<th><i class="fas fa-hashtag me-1 text-primary"></i> ID</th>
											<th><i class="fas fa-user-shield me-1 text-dark"></i> USERNAME</th>
											<th><i class="fas fa-tasks me-1 text-info"></i> HÀNH ĐỘNG</th>
											<th><i class="fab fa-chrome me-1 text-success"></i> TRÌNH DUYỆT</th>
											<th><i class="fas fa-mobile-alt me-1 text-secondary"></i> THIẾT BỊ</th>
											<th><i class="fas fa-network-wired me-1 text-danger"></i> IP</th>
											<th><i class="fas fa-map-marker-alt me-1 text-warning"></i> VỊ TRÍ</th>
											<th><i class="far fa-clock me-1 text-primary"></i> THỜI GIAN</th>
										</tr>
									</thead>
									<tbody id="logTableBody">
										<?php
											// ===============================
											// 🎨 Style hiển thị trình duyệt & thiết bị
											// ===============================
											$browserStyles = [
												'Chrome'   => ['icon' => 'fab fa-chrome',  'color' => 'primary'],
												'Firefox'  => ['icon' => 'fab fa-firefox-browser', 'color' => 'warning'],
												'Edge'     => ['icon' => 'fab fa-edge', 'color' => 'info'],
												'Safari'   => ['icon' => 'fab fa-safari', 'color' => 'purple'],
												'Opera'    => ['icon' => 'fab fa-opera', 'color' => 'danger'],
												'Cốc Cốc'  => ['icon' => 'fas fa-leaf', 'color' => 'success'],
												'Unknown'  => ['icon' => 'fas fa-question-circle', 'color' => 'muted'],
											];
											
											$deviceStyles = [
												'Windows'   => ['icon' => 'fab fa-windows', 'color' => 'primary'],
												'Mac OS X'  => ['icon' => 'fab fa-apple',   'color' => 'secondary'],
												'Linux'     => ['icon' => 'fab fa-linux',   'color' => 'dark'],
												'Android'   => ['icon' => 'fab fa-android', 'color' => 'success'],
												'iOS'       => ['icon' => 'fab fa-apple',   'color' => 'purple'],
												'Unknown'   => ['icon' => 'fas fa-question-circle', 'color' => 'muted'],
											];
											
											// ===============================
											// 🧩 Kiểm tra dữ liệu trả về
											// ===============================
											if (empty($rows) || !is_array($rows)) :
											?>
										<tr>
											<td colspan="8" class="text-center text-muted py-3">
												Không có dữ liệu
											</td>
										</tr>
										<?php
											else:
												foreach ($rows as $row):
													$browser = trim($row['browser'] ?? '');
													$device  = trim($row['device'] ?? '');
													if ($browser === '' || $browser === null) $browser = 'Unknown';
													if ($device === '' || $device === null)   $device  = 'Unknown';
											
													$b = $browserStyles[$browser] ?? $browserStyles['Unknown'];
													$d = $deviceStyles[$device] ?? $deviceStyles['Unknown'];
											?>
										<tr>
											<td><?= $row['id'] ?></td>
											<td><span class="fw-semibold text-dark"><?= ($row['username']) ?></span></td>
											<td><?= ($row['title']) ?></td>
											<!-- Browser -->
											<td>
												<span class="badge border border-<?= $b['color'] ?> text-<?= $b['color'] ?>">
												<i class="<?= $b['icon'] ?> me-1"></i><?= ($browser) ?>
												</span>
											</td>
											<!-- Device -->
											<td>
												<span class="badge border border-<?= $d['color'] ?> text-<?= $d['color'] ?>">
												<i class="<?= $d['icon'] ?> me-1"></i><?= ($device) ?>
												</span>
											</td>
											<!-- IP -->
											<td><span class="badge border border-danger text-danger"><?= ($row['ip']) ?></span></td>
											<!-- Address -->
											<td><?= ($row['address'] ?: '—') ?></td>
											<!-- Time -->
											<td><span class="text-primary"><?= fmDate($row['time']) ?></span></td>
										</tr>
										<?php
											endforeach;
											endif;
											?>
									</tbody>
								</table>
								<!--end /table-->
							</div>
							<!--end /tableresponsive-->          
						</div>
						<!-- ================== PHẦN CHÂN (PHÂN TRANG) ================== -->
						<div class="card-footer bg-light border-top pt-3">
							<div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-3">
								<!-- Hiển thị thông tin số bản ghi -->
								<div class="order-2 order-md-1 text-muted small">
									Hiển thị <b><?= $from_record ?></b>–<b><?= $to_record ?></b> / <b><?= $total_records ?></b> bản ghi
								</div>
								<!-- PHÂN TRANG --> 
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
					<!--end card-->
					<script>
						"use strict";
						document.addEventListener("DOMContentLoaded", () => {
						  // ============================
						  // ⚙️ CẤU HÌNH CƠ BẢN
						  // ============================
						  const TOTAL_PAGES = <?= (int)$total_pages ?>;
						  const CURRENT_PAGE = <?= (int)$page ?>;
						  const paginationLinks = document.querySelectorAll(".pagination .page-link");
						  const limitSelect = document.getElementById("limitSelect");
						  const sortSelect = document.getElementById("sortSelect");
						
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
						  // 🧭 PHÂN TRANG THÔNG MINH
						  // ============================
						  const goToPage = page => {
						    page = Math.max(1, Math.min(page, TOTAL_PAGES));
						    const params = new URLSearchParams(window.location.search);
						    params.set("page", page);
						    params.set("limit", limitSelect.value);
						    params.set("sort", sortSelect.value);
						    window.location.href = `${window.location.pathname}?${params.toString()}`;
						  };
						
						  const updatePaginationButtons = () => {
						    paginationLinks.forEach(link => {
						      const action = link.dataset.action;
						      const li = link.closest(".page-item");
						      li.classList.remove("disabled");
						      if ((["first", "prev"].includes(action) && CURRENT_PAGE === 1) ||
						          (["next", "last"].includes(action) && CURRENT_PAGE === TOTAL_PAGES)) {
						        li.classList.add("disabled");
						        link.setAttribute("aria-disabled", "true");
						        link.setAttribute("tabindex", "-1");
						      } else {
						        link.removeAttribute("aria-disabled");
						        link.removeAttribute("tabindex");
						      }
						    });
						  };
						
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
						  updatePaginationButtons();
						
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
						  const tableBody = document.getElementById("logTableBody");
						  const originalRows = Array.from(tableBody.querySelectorAll("tr")).map(tr => tr.cloneNode(true));
						
						  const filterEls = {
						    idUser: document.getElementById("filterIdUser"),
						    username: document.getElementById("filterUsername"),
						    ip: document.getElementById("filterIp"),
						    device: document.getElementById("filterDevice"),
						    time: document.getElementById("filterTime"),
						    reset: document.getElementById("resetLogFilter"),
						  };
						
						  // Debounce để tránh lọc quá nhanh
						  const debounce = (fn, delay = 300) => {
						    let timer;
						    return (...args) => {
						      clearTimeout(timer);
						      timer = setTimeout(() => fn.apply(this, args), delay);
						    };
						  };
						
						  const applyFilter = () => {
						    const idUserVal = filterEls.idUser.value.trim().toLowerCase();
						    const usernameVal = filterEls.username.value.trim().toLowerCase();
						    const ipVal = filterEls.ip.value.trim().toLowerCase();
						    const deviceVal = filterEls.device.value.trim().toLowerCase();
						    const timeVal = filterEls.time.value ? filterEls.time.value.split("-").reverse().join("/") : "";
						
						    const filtered = originalRows.filter(tr => {
						      const tds = tr.querySelectorAll("td");
						      if (tds.length < 8) return false;
						      const id = tds[0].innerText.toLowerCase();
						      const username = tds[1].innerText.toLowerCase();
						      const device = tds[4].innerText.toLowerCase();
						      const ip = tds[5].innerText.toLowerCase();
						      const timeText = tds[7].innerText.trim();
						      return (
						        (!idUserVal || id.includes(idUserVal)) &&
						        (!usernameVal || username.includes(usernameVal)) &&
						        (!ipVal || ip.includes(ipVal)) &&
						        (!deviceVal || device.includes(deviceVal)) &&
						        (!timeVal || timeText.includes(timeVal))
						      );
						    });
						
						    tableBody.innerHTML = filtered.length
						      ? filtered.map(tr => tr.outerHTML).join("")
						      : `<tr><td colspan="8" class="text-center text-muted py-3">Không tìm thấy kết quả phù hợp</td></tr>`;
						  };
						
						  // Gắn sự kiện lọc (debounce)
						  [filterEls.idUser, filterEls.username, filterEls.ip, filterEls.device, filterEls.time].forEach(el => {
						    if (el) {
						      el.addEventListener("input", debounce(applyFilter, 400));
						      el.addEventListener("change", applyFilter);
						    }
						  });
						
						  // ============================
						  // 🧹 Nút Xóa lọc
						  // ============================
						  filterEls.reset?.addEventListener("click", e => {
						    e.preventDefault();
						    Object.values(filterEls).forEach(i => {
						      if (i && i.tagName === "INPUT") i.value = "";
						    });
						
						    if (limitSelect) limitSelect.value = "10";
						    if (sortSelect) sortSelect.value = "asc";
						
						    const baseUrl = window.location.origin + window.location.pathname;
						    const params = new URLSearchParams({ page: 1, limit: 10, sort: "asc" });
						    window.location.href = `${baseUrl}?${params.toString()}`;
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
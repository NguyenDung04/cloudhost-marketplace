<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Lịch sử Mua Hosting";
			?>
		<title><?php echo $title; ?></title>
		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
        <style>
            .fancy-status {
                font-weight: 600;
                border-radius: 10px;
                padding: 5px 8px;
                cursor: pointer;
                transition: all 0.2s ease-in-out;
            }

            /* Hiệu ứng hover */
            .fancy-status:hover {
                box-shadow: 0 0 6px rgba(0,0,0,0.15);
            }

            /* Trạng thái hoạt động */
            .fancy-status option[value="hoatdong"] {
                background-color: #d4f8d4;
                color: #0a7d00;
            }

            /* Trạng thái tạm khóa */
            .fancy-status option[value="tamkhoa"] {
                background-color: #fff3cd;
                color: #a66a00;
            }

            /* Trạng thái hết hạn */
            .fancy-status option[value="hethang"] {
                background-color: #f8d7da;
                color: #b30000;
            }

        </style>
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
					$total_records = $ketnoi->num_rows("SELECT * FROM `history_buy_hosting`");
					
					// Tổng số trang
					$total_pages = ceil($total_records / $limit);
					
					// Lấy dữ liệu theo trang + sắp xếp
					$rows = $ketnoi->get_list("SELECT * FROM `history_buy_hosting` $orderBy LIMIT $offset, $limit");
					
					// Tính chỉ số hiển thị
					$from_record = $total_records > 0 ? $offset + 1 : 0;
					$to_record   = min($offset + $limit, $total_records);
				?>
				<div class="card">
					<!-- ================= HEADER ================= -->
					<div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
						<h4 class="card-title mb-0 text-uppercase fw-semibold">
							<i class="fas fa-server text-primary me-2"></i><?php echo $title ?? 'Lịch sử Mua Hosting'; ?>
						</h4> 
					</div>
					<!-- ================= FILTER ================= -->
                    <div class="card-body">
                        <form id="filterHistoryForm" class="row g-3 align-items-center flex-wrap justify-content-between">

                            <!-- ID -->
                            <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hashtag text-primary"></i></span>
                                    <input type="text" class="form-control py-2 fs-6" id="filterId" placeholder="Nhập ID giao dịch">
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user text-success"></i></span>
                                    <input type="text" class="form-control py-2 fs-6" id="filterUsername" placeholder="Tên người dùng">
                                </div>
                            </div>

                            <!-- Domain -->
                            <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-globe-asia text-info"></i></span>
                                    <input type="text" class="form-control py-2 fs-6" id="filterDomain" placeholder="Tên miền">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-toggle-on text-danger"></i></span>
                                    <select class="form-select py-2 fs-6" id="filterStatus">
                                        <option value="">Tất cả trạng thái</option>
                                        <option value="hoatdong">Hoạt động</option>
                                        <option value="tamngung">Tạm ngừng</option>
                                        <option value="hethan">Hết hạn</option>
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

                        <!-- PAGINATION -->
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-3 border-top pt-3">
                            <div class="text-muted small order-2 order-md-1">
                                <i class="far fa-list-alt me-1"></i>
                                Showing <b><?= $from_record ?></b>–<b><?= $to_record ?></b>
                                of <b><?= $total_records ?></b> records
                            </div>

                            <div class="d-flex align-items-center gap-3 order-1 order-md-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold text-muted small">Hiển thị:</span>
                                    <select class="form-select form-select-sm w-auto" id="limitSelect"
                                            onchange="window.location='?page=1&limit='+this.value+'&sort=<?= $sort ?>'">
                                        <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                                        <option value="25" <?= $limit == 25 ? 'selected' : '' ?>>25</option>
                                        <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
                                        <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100</option>
                                    </select>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold text-muted small">Sắp xếp:</span>
                                    <select class="form-select form-select-sm w-auto" id="sortSelect"
                                            onchange="window.location='?page=1&limit=<?= $limit ?>&sort='+this.value">
                                        <option value="asc" <?= $sort == 'asc' ? 'selected' : '' ?>>Cũ nhất</option>
                                        <option value="desc" <?= $sort == 'desc' ? 'selected' : '' ?>>Mới nhất</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

					<!-- ================= BẢNG LỊCH SỬ MUA HOSTING ================= -->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle mb-0">
                                <thead class="table-light text-uppercase text-secondary fw-semibold">
                                    <tr>
                                        <th><i class="fas fa-hashtag me-1 text-muted"></i>ID</th>
                                        <th><i class="fas fa-user me-1 text-primary"></i>Username</th>
                                        <th><i class="fas fa-globe me-1 text-success"></i>Domain</th>
                                        <th><i class="fas fa-box me-1 text-warning"></i>Gói host</th>
                                        <th><i class="fas fa-server me-1 text-info"></i>Server</th>
                                        <th><i class="fas fa-coins me-1 text-danger"></i>Giá</th>
                                        <th><i class="fas fa-user-circle me-1 text-primary"></i>Tài khoản</th>
                                        <th><i class="fas fa-key me-1 text-warning"></i>Mật khẩu</th>
                                        <th><i class="fas fa-calendar-plus me-1 text-success"></i>Ngày tạo</th>
                                        <th><i class="fas fa-calendar-times me-1 text-danger"></i>Ngày hết hạn</th>
                                        <th><i class="fas fa-info-circle me-1 text-secondary"></i>Trạng thái</th>
                                     </tr>
                                </thead>

                                <tbody id="historyBuyHostingTableBody">
                                    <?php if (!empty($rows)): ?>
                                    <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>

                                        <td class="fw-semibold text-primary"><?= ($row['username']) ?></td>

                                        <td><?= ($row['domain']) ?></td>

                                        <td><span class="badge bg-primary"><?= ($row['pk_host']) ?></span></td>

                                        <td><?= ($row['sv_host']) ?></td>

                                        <td class="fw-bold text-danger"><?= money($row['money']) ?></td>

                                        <td>
                                            <span class="text-primary fw-semibold"><?= shortText(decodecryptData($row['account'])) ?></span>
                                        </td>

                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="password"
                                                    class="form-control border-0 bg-transparent p-0 text-muted copy-text"
                                                    value="<?= (decodecryptData($row['password'])) ?>"
                                                    readonly>

                                                <button class="btn btn-outline-secondary btn-sm btn-toggle-pass" type="button"
                                                    title="Hiển thị mật khẩu">
                                                    <i class="fas fa-eye-slash"></i>
                                                </button>

                                                <button class="btn btn-outline-secondary btn-sm btn-copy" type="button"
                                                    title="Sao chép mật khẩu">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </td>


                                        <td><?= fmDate($row['creatAt']) ?></td>

                                        <td><?= fmDate($row['endAt']) ?></td>

                                        <td>
                                            <select class="form-select form-select-sm status-select fancy-status" data-id="<?= $row['id'] ?>">
                                                <option value="hoatdong" <?= $row['status'] === 'hoatdong' ? 'selected' : '' ?>>
                                                    🟢 Hoạt động
                                                </option>

                                                <option value="tamkhoa" <?= $row['status'] === 'tamkhoa' ? 'selected' : '' ?>>
                                                    🟡 Tạm khóa
                                                </option>

                                                <option value="hethan" <?= $row['status'] === 'hethan' ? 'selected' : '' ?>>
                                                    🔴 Hết hạn
                                                </option>
                                            </select>
                                        </td>

                                    </tr> 

                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="12" class="text-center text-muted">Không có dữ liệu</td>
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

                                const res = await fetch("/ajax/admin/history/history_buy_hosting.php", {
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
                        // 📋 COPY TEXT & HIỂN THỊ MẬT KHẨU
                        // ==================================================
                        document.addEventListener("click", e => {
                            const btnCopy = e.target.closest(".btn-copy");
                            if (btnCopy) {
                                const input = btnCopy.closest(".input-group").querySelector(".copy-text");
                                navigator.clipboard.writeText(input.value).then(() => {
                                    btnCopy.innerHTML = '<i class="fas fa-check text-success"></i>';
                                    setTimeout(() => btnCopy.innerHTML = '<i class="fas fa-copy"></i>', 1000);
                                });
                            }
                    
                            const btnPass = e.target.closest(".btn-toggle-pass");
                            if (btnPass) {
                                const input = btnPass.closest(".input-group").querySelector("input");
                                const icon = btnPass.querySelector("i");
                                const isHidden = input.type === "password";
                                input.type = isHidden ? "text" : "password";
                                icon.classList.toggle("fa-eye");
                                icon.classList.toggle("fa-eye-slash");
                            }
                        });
                    
                    
                        // ==================================================
                        // 🧭 PHÂN TRANG + LỌC CLIENT-SIDE
                        // ==================================================
                        const TOTAL_PAGES = <?= (int)$total_pages ?>;
                        const CURRENT_PAGE = <?= (int)$page ?>;

                        // Body bảng
                        const tableBody = document.getElementById("historyBuyHostingTableBody");

                        // Clone toàn bộ row ban đầu → dùng lại khi reset
                        const originalRows = Array.from(tableBody.querySelectorAll("tr")).map(tr => tr.cloneNode(true));

                        // ================== FILTER ELEMENTS ==================
                        const filterEls = {
                            id: document.getElementById("filterId"),
                            username: document.getElementById("filterUsername"),
                            domain: document.getElementById("filterDomain"),
                            status: document.getElementById("filterStatus"),
                            reset: document.getElementById("resetFilter"),
                            limit: document.getElementById("limitSelect"),
                            sort: document.getElementById("sortSelect"),
                        };

                        // ================== APPLY FILTER ==================
                        function applyFilter() {
                            const idVal = filterEls.id.value.trim().toLowerCase();
                            const userVal = filterEls.username.value.trim().toLowerCase();
                            const domainVal = filterEls.domain.value.trim().toLowerCase();
                            const statusVal = filterEls.status.value.trim().toLowerCase();

                            const filtered = originalRows.filter(tr => {
                                const tds = tr.querySelectorAll("td");
                                if (tds.length < 5) return false;

                                const id = tds[0].innerText.toLowerCase();
                                const user = tds[1].innerText.toLowerCase();
                                const domain = tds[2].innerText.toLowerCase();
                                const status = tds[10]?.innerText?.toLowerCase() || "";

                                return (
                                    (!idVal || id.includes(idVal)) &&
                                    (!userVal || user.includes(userVal)) &&
                                    (!domainVal || domain.includes(domainVal)) &&
                                    (!statusVal || status.includes(statusVal))
                                );
                            });

                            tableBody.innerHTML = filtered.length
                                ? filtered.map(tr => tr.outerHTML).join("")
                                : `<tr><td colspan="12" class="text-center text-muted">Không tìm thấy kết quả phù hợp</td></tr>`;
                        }

                        // Gắn sự kiện filter
                        [filterEls.id, filterEls.username, filterEls.domain, filterEls.status].forEach(el => {
                            el?.addEventListener("input", applyFilter);
                            el?.addEventListener("change", applyFilter);
                        });

                        // ================== RESET FILTER ==================
                        filterEls.reset?.addEventListener("click", e => {
                            e.preventDefault();
                            filterEls.id.value =
                                filterEls.username.value =
                                filterEls.domain.value =
                                filterEls.status.value = "";

                            if (filterEls.limit) filterEls.limit.value = "10";
                            if (filterEls.sort) filterEls.sort.value = "asc";

                            tableBody.innerHTML = originalRows.map(tr => tr.outerHTML).join("");

                            // Load lại trang gốc
                            window.location.href = window.location.origin + window.location.pathname;
                        });

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
                        // ================= SHOW / HIDE PASSWORD =================
                        document.addEventListener("click", function (e) {
                            const btn = e.target.closest(".toggle-pass-view");
                            if (!btn) return;
            
                            const input = document.querySelector(btn.dataset.target);
                            const icon = btn.querySelector("i");
            
                            if (input.type === "password") {
                                input.type = "text";
                                icon.classList.remove("fa-eye-slash");
                                icon.classList.add("fa-eye");
                            } else {
                                input.type = "password";
                                icon.classList.remove("fa-eye");
                                icon.classList.add("fa-eye-slash");
                            }
                        });
            
                        // ================= COPY PASSWORD =================
                        document.addEventListener("click", function (e) {
                            const btn = e.target.closest(".copy-pass-view");
                            if (!btn) return;
            
                            const input = document.querySelector(btn.dataset.target);
            
                            navigator.clipboard.writeText(input.value).then(() => {
                                btn.innerHTML = '<i class="fas fa-check text-success"></i>';
                                setTimeout(() => {
                                    btn.innerHTML = '<i class="fas fa-copy"></i>';
                                }, 1000);
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
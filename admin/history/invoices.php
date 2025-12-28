<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Hóa đơn";
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
					$total_records = $ketnoi->num_rows("SELECT * FROM `invoices`");
					
					// Tổng số trang
					$total_pages = ceil($total_records / $limit);
					
					// Lấy dữ liệu theo trang + sắp xếp
					$rows = $ketnoi->get_list("SELECT * FROM `invoices` $orderBy LIMIT $offset, $limit");
					
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
                    <!-- ================= FILTER INVOICES ================= -->
                    <div class="card-body">
                        <form id="filterInvoicesForm" class="row g-3 align-items-center flex-wrap justify-content-between">
                            <!-- ID Invoice -->
                            <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hashtag text-primary"></i></span>
                                    <input type="text" class="form-control py-2 fs-6" id="filterId" placeholder="ID invoice">
                                </div>
                            </div>
                            <!-- Username -->
                            <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user text-success"></i></span>
                                    <input type="text" class="form-control py-2 fs-6" id="filterUsername" placeholder="Họ tên người dùng">
                                </div>
                            </div>
                            <!-- Title -->
                            <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-signature text-info"></i></span>
                                    <input type="text" class="form-control py-2 fs-6" id="filterTitle" placeholder="Tên hóa đơn">
                                </div>
                            </div>
                            <!-- ID Order (Code) -->
                            <div class="col-auto flex-fill">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-barcode text-warning"></i></span>
                                    <input type="text" class="form-control py-2 fs-6" id="filterIdOrder" placeholder="Mã đơn hàng">
                                </div>
                            </div>
                            <!-- Reset -->
                            <div class="col-auto">
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
                                Hiển thị <b><?= $from_record ?></b>–<b><?= $to_record ?></b>
                                / <b><?= $total_records ?></b> bản ghi
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
                    <!-- ================= BẢNG QUẢN LÝ INVOICES ================= -->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="table-light align-middle">
                                    <tr>
                                        <th><i class="fas fa-hashtag me-1 text-muted"></i>ID</th>
                                        <th><i class="fas fa-user me-1 text-primary"></i>Username</th>
                                        <th><i class="fas fa-barcode me-1 text-info"></i>Mã đơn hàng</th>
                                        <th><i class="fas fa-file-alt me-1 text-success"></i>Tiêu đề</th>
                                        <th><i class="fas fa-file-alt me-1 text-success"></i>Tổng tiền thanh toán</th>
                                        <th class="text-center"><i class="fas fa-clock me-1 text-warning"></i>Ngày thanh toán</th> 
                                        <th class="text-center"><i class="fas fa-clock me-1 text-warning"></i>Hóa đơn ngày</th> 
                                    </tr>
                                </thead>
                                <tbody id="invoicesTableBody">
                                    <?php if (!empty($rows)): ?>
                                    <?php foreach ($rows as $row): ?>
                                    <tr data-id="<?= $row['id'] ?>"
                                        data-username="<?= ($row['username'] ?? '') ?>"
                                        data-id_oder="<?= ($row['id_oder'] ?? '') ?>"
                                        data-title="<?= ($row['title'] ?? '') ?>"
                                        data-time="<?= ($row['time'] ?? '') ?>">
                                        <!-- ID -->
                                        <td class="fw-semibold"><?= $row['id'] ?? '' ?></td>
                                        <!-- Username -->
                                        <td class="fw-semibold"> 
                                            <?= !empty($row['username']) ? ($row['username']) : 'N/A' ?> 
                                        </td>
                                        <!-- ID Order (Code) -->
                                        <td>   
                                            <?php
                                                $id_order = $row['id_oder'];
                                                $orders = $ketnoi->get_row("SELECT * FROM `orders` WHERE `code` = '$id_order'"); 
                                            ?>  
                                            <span class="badge bg-success-subtle text-success border border-success">
                                                <?= (is_array($orders) && isset($orders['code']) && $row['id_oder'] === $orders['code'])
                                                    ? $orders['code']
                                                    : 'N/A'; ?>
                                            </span> 
                                        </td>
                                        <!-- Title -->
                                        <td class="fw-semibold"> 
                                            <?= !empty($row['title']) ? ($row['title']) : 'N/A' ?> 
                                        </td>
                                        <!-- Tổng tiền thanh toán -->
                                        <td class="fw-semibold"> 
                                            <?= !empty($orders['total_money']) ? money($orders['total_money']) : 'N/A' ?> 
                                        </td>
                                        <!-- Thời gian -->
                                        <td class="fw-semibold text-center">
                                            <?= fmDate($row['time']) ?> 
                                        </td> 
                                        <!-- Thời gian -->
                                        <td class="fw-semibold text-center"> 
                                            <?= fmDate(is_array($orders) ? ($orders['created_at'] ?? null) : null); ?> 
                                        </td> 
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-file-invoice fa-2x mb-3"></i><br>
                                            Không có dữ liệu hóa đơn
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
                        // 🔍 FILTER INVOICES 
                        // ==================================================  
                        const tableBody = document.getElementById("invoicesTableBody");

                        if (tableBody) {
                            // Clone toàn bộ row ban đầu
                            const originalRows = Array.from(tableBody.querySelectorAll("tr")).map(tr => tr.cloneNode(true));

                            // Filter elements
                            const filters = {
                                id: document.getElementById("filterId"),
                                username: document.getElementById("filterUsername"),
                                title: document.getElementById("filterTitle"),
                                idOrder: document.getElementById("filterIdOrder"),
                                reset: document.getElementById("resetFilter"),
                                limit: document.getElementById("limitSelect"),
								sort: document.getElementById("sortSelect")
                            };

                            // Apply filter function
                            function applyFilter() {
                                const values = {
                                    id: filters.id?.value.trim().toLowerCase() || "",
                                    username: filters.username?.value.trim().toLowerCase() || "",
                                    title: filters.title?.value.trim().toLowerCase() || "",
                                    idOrder: filters.idOrder?.value.trim().toLowerCase() || ""
                                };

                                const filtered = originalRows.filter(tr => {
                                    // Nếu là row "Không có dữ liệu" thì bỏ qua
                                    if (tr.querySelector('td[colspan]')) return false;

                                    const data = {
                                        id: tr.dataset.id?.toString().toLowerCase() || "",
                                        username: tr.dataset.username?.toLowerCase() || "",
                                        id_oder: tr.dataset.id_oder?.toLowerCase() || "",
                                        title: tr.dataset.title?.toLowerCase() || ""
                                    };

                                    // ID filter
                                    if (values.id && !data.id.includes(values.id)) return false;
                                    
                                    // Username filter
                                    if (values.username && !data.username.includes(values.username)) return false;
                                    
                                    // Title filter
                                    if (values.title && !data.title.includes(values.title)) return false;
                                    
                                    // ID Order filter
                                    if (values.idOrder && !data.id_oder.includes(values.idOrder)) return false;
                                    
                                    return true;
                                });

                                // Update table
                                if (filtered.length > 0) {
                                    tableBody.innerHTML = filtered.map(tr => tr.outerHTML).join("");
                                } else {
                                    tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-search fa-2x mb-3"></i><br>
                                        Không tìm thấy hóa đơn phù hợp
                                    </td></tr>`;
                                }
                            }

                            // Attach events to filter inputs
                            Object.values(filters).forEach(el => {
                                if (el && el !== filters.reset) {
                                    el.addEventListener('input', applyFilter);
                                }
                            });

                            // Reset filter
                            if (filters.reset) {
                                filters.reset.addEventListener("click", function(e) {
                                    e.preventDefault();
                                    
                                    // Reset filter inputs
                                    filters.id.value = "";
                                    filters.username.value = "";
                                    filters.title.value = "";
                                    filters.idOrder.value = "";

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
                        // 🧭 PHÂN TRANG INVOICES
                        // ==================================================
                        const TOTAL_PAGES = <?= (int)$total_pages ?>;
                        const CURRENT_PAGE = <?= (int)$page ?>;
                        const CURRENT_LIMIT = <?= (int)$limit ?>;
                        const CURRENT_SORT = '<?= addslashes($sort) ?>';

                        function goToPage(newPage) {
                            newPage = Math.max(1, Math.min(newPage, TOTAL_PAGES));
                            const params = new URLSearchParams(window.location.search);
                            
                            params.set("page", newPage);
                            params.set("limit", CURRENT_LIMIT);
                            params.set("sort", CURRENT_SORT);
                            
                            window.location.href = `${window.location.pathname}?${params.toString()}`;
                        }

                        // Sự kiện click phân trang
                        document.querySelectorAll(".pagination .page-link").forEach(link => {
                            link.addEventListener("click", function(e) {
                                e.preventDefault();
                                const li = this.closest(".page-item");
                                if (li.classList.contains("disabled")) return;
                                
                                let newPage = CURRENT_PAGE;
                                
                                switch (this.dataset.action) {
                                    case "first": newPage = 1; break;
                                    case "prev": newPage = CURRENT_PAGE - 1; break;
                                    case "next": newPage = CURRENT_PAGE + 1; break;
                                    case "last": newPage = TOTAL_PAGES; break;
                                    default:
                                        const num = parseInt(this.textContent.trim());
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
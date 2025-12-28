<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Bài viết";
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
					$total_records = $ketnoi->num_rows("SELECT * FROM `posts`");
					
					// Tổng số trang
					$total_pages = ceil($total_records / $limit);
					
					// Lấy dữ liệu theo trang + sắp xếp
					$rows = $ketnoi->get_list("SELECT * FROM `posts` $orderBy LIMIT $offset, $limit");
					
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
						<!-- NÚT THÊM BÀI VIẾT -->
						<button class="btn btn-primary fw-semibold d-flex align-items-center gap-1"
							data-bs-toggle="modal"
							data-bs-target="#addPostModal">
						<i class="fas fa-plus-circle"></i> Thêm bài viết
						</button>
					</div>
					<!-- ================= FILTER ================= -->
					<div class="card-body">
						<form id="filterPostsForm" class="row g-3 align-items-center flex-wrap justify-content-between">
							<!-- Tìm theo ID / Tiêu đề / Slug -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text">
									<i class="fas fa-search text-primary"></i>
									</span>
									<input type="text"
										class="form-control py-2 fs-6"
										id="filterKeyword"
										placeholder="Nhập ID, tiêu đề hoặc slug bài viết">
								</div>
							</div>
							<!-- Lọc theo Trạng thái -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text">
									<i class="fas fa-toggle-on text-warning"></i>
									</span>
									<select class="form-select py-2 fs-6" id="filterStatus">
										<option value="">Tất cả trạng thái</option>
										<option value="on">Hiển thị</option>
										<option value="off">Ẩn</option>
									</select>
								</div>
							</div>
							<!-- Nút reset -->
							<div class="col-auto">
								<button type="reset" class="btn btn-danger px-4 py-2 fw-semibold" id="resetFilterPosts">
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
					<!-- ================= BẢNG BÀI VIẾT (POSTS) ================= -->
					<div class="card-body pt-0">
						<div class="table-responsive">
							<table class="table table-striped align-middle mb-0">
								<thead class="table-light text-uppercase text-secondary fw-semibold">
									<tr>
										<th><i class="fas fa-hashtag me-1 text-muted"></i>ID</th>
										<th><i class="fas fa-heading me-1 text-primary"></i>Tiêu đề</th>
										<th><i class="fas fa-list-ul me-1 text-info"></i>Loại</th>
										<th><i class="fas fa-user-edit me-1 text-secondary"></i>Tài khoản</th>
										<th><i class="fas fa-eye me-1 text-warning"></i>Lượt xem</th>
										<th><i class="fas fa-toggle-on me-1 text-danger"></i>Trạng thái</th>
										<th><i class="fas fa-clock me-1 text-muted"></i>Thời gian</th>
										<th class="text-center"><i class="fas fa-cogs me-1 text-secondary"></i>Hành động</th>
									</tr>
								</thead>
								<tbody id="postsTableBody">
									<?php if (!empty($rows)): ?>
									<?php foreach ($rows as $row): ?>
									<tr data-status="<?= $row['status'] ?>" data-type="<?= $row['type'] ?>">
										<td><?= $row['id'] ?></td>
										<td class="fw-semibold text-primary">
											<?= htmlspecialchars($row['title']) ?><br>
											<small class="text-muted"><?= htmlspecialchars($row['slug']) ?></small>
										</td>
										<td><span class="badge rounded-pill bg-info-subtle text-info"><?= htmlspecialchars($row['type']) ?></span></td>
										<td><span class="badge bg-light text-secondary"><?= htmlspecialchars($row['username']) ?></span></td>
										<td><?= (int)$row['view'] ?></td>
										<td>
											<div class="form-check form-switch d-inline-flex align-items-center justify-content-center">
												<input class="form-check-input toggle-status" type="checkbox" role="switch"
													data-id="<?= $row['id'] ?>" <?= $row['status'] == 'on' ? 'checked' : '' ?>>
											</div>
										</td>
										<td><?= !empty($row['time']) ? fmDate($row['time']) : '-' ?></td>
										<td class="text-center">
											<button class="btn btn-outline-primary btn-sm me-1"
												data-bs-toggle="collapse"
												data-bs-target="#editRow_<?= $row['id'] ?>">
											<i class="fas fa-pen-to-square me-1"></i>Sửa
											</button>
											<button class="btn btn-outline-danger btn-sm btn-delete-post"
												data-id="<?= $row['id'] ?>"
												data-title="<?= htmlspecialchars($row['title']) ?>">
											<i class="fas fa-trash-alt me-1"></i>Xóa
											</button>
										</td>
									</tr>
									<!-- 🧩 EDITOR INLINE: hiển thị ngay dưới dòng -->
									<tr class="collapse" id="editRow_<?= $row['id'] ?>">
										<td colspan="9">
											<?php
												$contentDecoded = '';
												if (!empty($row['content'])) {
												$decoded = base64_decode($row['content'], true);
												$contentDecoded = $decoded !== false ? $decoded : '';
												}
												$editorId = 'postContent_' . $row['id'];
												$previewId = 'preview_post_' . $row['id'];
												?>
											<form class="editPostForm" data-id="<?= $row['id'] ?>" method="POST" enctype="multipart/form-data">
												<div class="row g-3">
													<div class="col-md-4">
														<label class="form-label fw-semibold">Tài khoản</label>
														<input type="text" class="form-control" name="username"
															value="<?= htmlspecialchars($row['username']) ?>" readonly>
													</div>
													<div class="col-md-4">
														<label class="form-label fw-semibold">Thứ tự hiển thị (stt)</label>
														<input type="number" class="form-control" name="stt" value="<?= (int)$row['stt'] ?>" min="0">
													</div>
													<div class="col-md-4">
														<label class="form-label fw-semibold">Loại bài viết (type)</label>
														<input type="text" class="form-control" name="type" value="<?= htmlspecialchars($row['type']) ?>">
													</div>
													<div class="col-md-12">
														<label class="form-label fw-semibold">Tiêu đề</label>
														<input type="text" class="form-control" name="title"
															value="<?= htmlspecialchars($row['title']) ?>" required>
													</div>
													<div class="col-md-12">
														<label class="form-label fw-semibold">Slug</label>
														<input type="text" class="form-control" name="slug" value="<?= htmlspecialchars($row['slug']) ?>">
													</div>
													<!-- ẢNH: PREVIEW + CHỌN ẢNH MỚI -->
													<div class="col-md-6">
														<label class="form-label fw-semibold">Ảnh hiện tại</label>
														<?php if (!empty($row['image'])): ?>
														<div class="border rounded p-2 text-center bg-light">
															<img src="<?= htmlspecialchars($row['image']) ?>" alt="Post image"
																class="img-fluid rounded" id="<?= $previewId ?>" style="max-height: 80px;">
														</div>
														<?php else: ?>
														<div class="border rounded p-3 text-center text-muted bg-light" id="<?= $previewId ?>">
															Chưa có ảnh
														</div>
														<?php endif; ?>
													</div>
													<div class="col-md-6">
														<label class="form-label fw-semibold">Chọn ảnh mới</label>
														<input type="file" class="form-control image-input" name="image_file" accept="image/*"
															data-preview="<?= $previewId ?>">
														<input type="hidden" name="old_image" value="<?= htmlspecialchars($row['image']) ?>">
														<small class="text-muted">Không chọn thì giữ nguyên ảnh hiện tại.</small>
													</div>
													<!-- NỘI DUNG: kiểu Word (CKEditor) -->
													<div class="col-md-12">
														<label class="form-label fw-semibold">Nội dung chi tiết</label>
														<textarea class="form-control editor-post" name="content"
															id="<?= $editorId ?>" rows="12"><?= htmlspecialchars($contentDecoded, ENT_QUOTES, 'UTF-8') ?></textarea>
													</div>
													<div class="col-md-4">
														<label class="form-label fw-semibold">Lượt xem (view)</label>
														<input type="number" class="form-control" name="view" value="<?= (int)$row['view'] ?>" min="0">
													</div>
													<div class="col-md-4">
														<label class="form-label fw-semibold">Trạng thái</label>
														<select class="form-select" name="status">
															<option value="on"  <?= $row['status'] === 'on' ? 'selected' : '' ?>>Hiển thị</option>
															<option value="off" <?= $row['status'] === 'off' ? 'selected' : '' ?>>Ẩn</option>
														</select>
													</div>
													<div class="col-md-4">
														<label class="form-label fw-semibold">Thời gian tạo</label>
														<input type="text" class="form-control" value="<?= !empty($row['time']) ? fmDate($row['time']) : '-' ?>" readonly>
													</div>
													<div class="col-12 d-flex justify-content-end gap-2">
														<button type="button" class="btn btn-secondary"
															data-bs-toggle="collapse" data-bs-target="#editRow_<?= $row['id'] ?>">
														<i class="fas fa-times me-1"></i>Đóng
														</button>
														<button type="submit" class="btn btn-warning fw-semibold">
														<i class="fas fa-save me-1"></i>Cập nhật
														</button>
													</div>
												</div>
											</form>
										</td>
									</tr>
									<?php endforeach; ?>
									<?php else: ?>
									<tr>
										<td colspan="9" class="text-center text-muted">Không có bài viết nào</td>
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
				<!-- 🧩 MODAL THÊM BÀI VIẾT -->
				<div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-xl modal-dialog-centered">
						<div class="modal-content border-0 shadow-lg rounded-3">
							<div class="modal-header bg-primary text-white">
								<h5 class="modal-title fw-semibold" id="addPostModalLabel">
									<i class="fas fa-plus-circle me-2"></i>Thêm bài viết
								</h5>
								<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
							</div>
							<form id="addPostForm" class="addPostForm" method="POST" enctype="multipart/form-data">
								<div class="modal-body p-4">
									<div class="row g-3">
										<div class="col-md-12">
											<label class="form-label fw-semibold">Tiêu đề</label>
											<input type="text" class="form-control" name="title" placeholder="Tiêu đề bài viết" required>
										</div>
										<div class="col-md-6">
											<label class="form-label fw-semibold">Loại bài viết (type)</label>
											<input type="text" class="form-control" name="type" placeholder="vd: huong-dan">
										</div> 
										<div class="col-md-6">
											<label class="form-label fw-semibold">Trạng thái</label>
											<select class="form-select" name="status">
												<option value="on" selected>Hiển thị</option>
												<option value="off">Ẩn</option>
											</select>
										</div> 
										<!-- ẢNH: PREVIEW + CHỌN ẢNH -->
										<div class="col-md-6">
											<label class="form-label fw-semibold">Preview ảnh</label>
											<div class="border rounded p-3 text-center text-muted bg-light" id="addPostPreview">
												Chưa chọn ảnh
											</div>
										</div>
										<div class="col-md-6">
											<label class="form-label fw-semibold">Chọn ảnh (image)</label>
											<input type="file" class="form-control image-input" name="image_file" accept="image/*" data-preview="addPostPreview">
											<small class="text-muted">Có thể bỏ trống.</small>
										</div>
										<!-- NỘI DUNG (KIỂU WORD – CKEditor) -->
										<div class="col-md-12">
											<label class="form-label fw-semibold">Nội dung chi tiết</label>
											<textarea class="form-control editor-post" name="content" id="addPostContent" rows="12"></textarea>
											<small class="text-muted">Soạn thảo như Word; hình ảnh trong nội dung nếu cần sẽ cấu hình upload sau.</small>
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
				<!-- CKEditor 5 Classic (CDN) -->
				<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@42.0.0/build/ckeditor.js"></script>
				<script>
					(function () {
					// Preview ảnh khi chọn file mới (.image-input)
					document.addEventListener('change', (e) => {
						const input = e.target.closest('.image-input');
						if (!input || !input.files?.[0]) return;
						const previewId = input.dataset.preview;
						const previewEl = document.getElementById(previewId);
						if (!previewEl) return;
					
						const reader = new FileReader();
						reader.onload = ev => {
						if (previewEl.tagName.toLowerCase() === 'img') {
							previewEl.src = ev.target.result;
						} else {
							previewEl.innerHTML = `<img src="${ev.target.result}" class="img-fluid rounded" style="max-height:80px;">`;
						}
						};
						reader.readAsDataURL(input.files[0]);
					});
					
					// Khởi tạo CKEditor khi hàng collapse mở
					const editors = new Map();
					const ckOptions = {
						toolbar: [
						'heading', '|',
						'bold','italic','underline','strikethrough','|',
						'link','bulletedList','numberedList','outdent','indent','|',
						'alignment','blockQuote','insertTable','horizontalLine','|',
						'undo','redo'
						],
						table: { contentToolbar: ['tableColumn','tableRow','mergeTableCells'] }
					};
					
					document.addEventListener('shown.bs.collapse', async (ev) => {
						const row = ev.target; // <tr.collapse>
						const textarea = row.querySelector('.editor-post');
						if (!textarea) return;
						const id = textarea.id || ('postContent_' + Date.now());
						if (!textarea.id) textarea.id = id;
						if (editors.has(id)) return;
					
						try {
						const instance = await ClassicEditor.create(textarea, ckOptions);
						editors.set(id, instance);
						} catch (err) { console.error('CKEditor init error:', err); }
					});
					
					// Đồng bộ HTML từ editor về textarea trước khi submit (add/sửa)
					document.addEventListener('submit', (e) => {
						const form = e.target.closest('.editPostForm, .addPostForm');
						if (!form) return;
						const textarea = form.querySelector('.editor-post');
						if (!textarea) return;
						const ed = editors.get(textarea.id);
						if (ed) textarea.value = ed.getData();
					});
					})();
				</script> 
				<script>
					(function () {
					// Preview ảnh
					document.addEventListener('change', (e) => {
						const input = e.target.closest('.image-input');
						if (!input || !input.files?.[0]) return;
						const previewEl = document.getElementById(input.dataset.preview);
						if (!previewEl) return;
					
						const reader = new FileReader();
						reader.onload = ev => {
						previewEl.innerHTML = `<img src="${ev.target.result}" class="img-fluid rounded" style="max-height:120px;">`;
						};
						reader.readAsDataURL(input.files[0]);
					});
					
					// CKEditor cho modal thêm
					let addEditor = null;
					const toolbar = [
						'heading','|','bold','italic','underline','strikethrough','|',
						'link','bulletedList','numberedList','outdent','indent','|',
						'alignment','blockQuote','insertTable','horizontalLine','|','undo','redo'
					];
					
					document.getElementById('addPostModal')?.addEventListener('shown.bs.modal', async () => {
						const ta = document.getElementById('addPostContent');
						if (!ta || addEditor) return;
						addEditor = await ClassicEditor.create(ta, {
						toolbar,
						table: { contentToolbar: ['tableColumn','tableRow','mergeTableCells'] }
						});
					});
					
					// Đồng bộ HTML từ editor -> textarea trước khi submit
					document.getElementById('addPostForm')?.addEventListener('submit', (e) => {
						const ta = document.getElementById('addPostContent');
						if (ta && addEditor) ta.value = addEditor.getData();
					});
					})();
				</script>
				<script>
					"use strict";
					
					document.addEventListener("DOMContentLoaded", () => {
						const apiUrl = "/ajax/admin/features/discount.php"; 
					
						// ==================================================
						// 🟢 THÊM MÃ GIẢM GIÁ (AJAX)
						// ==================================================
						const addForm = document.querySelector(".addDiscountForm"); 
						addForm?.addEventListener("submit", async (e) => {
							e.preventDefault();
							const form = e.target;
							const fd = new FormData(form);
							fd.append("action", "ADD_DISCOUNT");
							
							try {
								const res = await fetch(apiUrl, {
									method: "POST",
									body: fd
								});
								const data = await res.json();
					
								if (data.status === "success") {
									showAlert3(
										"success",
										"Thành công",
										"Đã thêm mã giảm giá mới vào hệ thống!",
										2000,
										() => location.reload()
									);
									bootstrap.Modal
										.getInstance(document.getElementById("addDiscountModal"))
										?.hide();
								} else {
									showAlert3(
										"error",
										"Thất bại",
										data.message || "Không thể thêm mã giảm giá!"
									);
								}
							} catch {
								showAlert3(
									"error",
									"Lỗi kết nối",
									"Không thể gửi dữ liệu lên máy chủ!"
								);
							}
						}); 
					
						// ==================================================
						// 🟣 SỬA MÃ GIẢM GIÁ (AJAX)
						// ==================================================
						document.addEventListener("submit", async (e) => {
							const form = e.target.closest(".editDiscountForm");
							if (!form) return;
					
							e.preventDefault();
					
							const id = form.dataset.id;
							const fd = new FormData(form);
							fd.append("id", id);
							fd.append("action", "UPDATE_DISCOUNT");
					
							try {
								const res = await fetch(apiUrl, {
									method: "POST",
									body: fd
								});
								const data = await res.json();
					
								if (data.status === "success") {
									showAlert3(
										"success",
										"Thành công",
										data.message || "Cập nhật mã giảm giá thành công!",
										1500,
										() => location.reload()
									);
									bootstrap.Modal.getInstance(form.closest(".modal"))?.hide();
								} else {
									showAlert3(
										"error",
										"Lỗi",
										data.message || "Không thể cập nhật mã giảm giá!"
									);
								}
							} catch {
								showAlert3(
									"error",
									"Kết nối thất bại",
									"Không thể gửi yêu cầu lên máy chủ!"
								);
							}
						});
					
						// ==================================================
						// 🟡 CẬP NHẬT TRẠNG THÁI MÃ GIẢM GIÁ (AJAX)
						// ==================================================
						document.addEventListener("change", async (e) => {
							const toggle = e.target.closest(".toggle-status");
							if (!toggle) return;
					
							const id = toggle.dataset.id;
							const newStatus = toggle.checked ? "on" : "off";
							toggle.disabled = true;
					
							try {
								const res = await fetch(apiUrl, {
									method: "POST",
									headers: { "Content-Type": "application/x-www-form-urlencoded" },
									body: new URLSearchParams({
										action: "UPDATE_DISCOUNT_STATUS",
										id,
										status: newStatus
									})
								});
								const data = await res.json();
					
								if (data.status === "success") {
									showAlert3(
										"success",
										"Thành công",
										`Mã giảm giá #${id} đã được ${newStatus === "on" ? "kích hoạt" : "tạm tắt"}.`
									);
								} else {
									showAlert3(
										"error",
										"Lỗi",
										data.message || "Không thể cập nhật trạng thái."
									);
									toggle.checked = !toggle.checked;
								}
							} catch {
								showAlert3(
									"error",
									"Kết nối thất bại",
									"Không thể gửi yêu cầu lên máy chủ."
								);
								toggle.checked = !toggle.checked;
							} finally {
								toggle.disabled = false;
							}
						});
					
						// ==================================================
						// 🔴 XÓA MÃ GIẢM GIÁ (AJAX)
						// ==================================================
						document.addEventListener("click", (e) => {
							const btn = e.target.closest(".btn-delete-discount");
							if (!btn) return;
					
							const id = btn.dataset.id;
							const code = btn.dataset.code || `#${id}`;
					
							Swal.fire({
								icon: "warning",
								title: "Xác nhận xóa?",
								html: `<div class="fw-semibold text-danger">Bạn có chắc muốn xóa mã giảm giá <b>${code}</b>?</div>
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
											action: "DELETE_DISCOUNT",
											id
										})
									});
					
									const data = await res.json();
									if (data.status === "success") {
										showAlert3(
											"success",
											"Thành công",
											data.message || `Đã xóa mã giảm giá ${code}!`,
											1800,
											() => location.reload()
										);
									} else {
										showAlert3(
											"error",
											"Lỗi",
											data.message || "Không thể xóa mã giảm giá này!"
										);
									}
								} catch {
									showAlert3(
										"error",
										"Kết nối thất bại",
										"Không thể gửi yêu cầu lên máy chủ!"
									);
								}
							});
						});
					
						// ==================================================
						// 🧭 PHÂN TRANG + LỌC CLIENT-SIDE CHO POSTS
						// ==================================================
						const TOTAL_PAGES  = <?= (int)$total_pages ?>;
						const CURRENT_PAGE = <?= (int)$page ?>;

						const tableBody = document.getElementById("postsTableBody");
						if (tableBody) {
						// Chỉ clone các hàng dữ liệu chính (ít nhất 2 cột). Hàng editor inline (colspan) sẽ bị loại.
						const originalRows = Array.from(tableBody.querySelectorAll("tr"))
							.filter(tr => tr.querySelectorAll("td").length >= 2)
							.map(tr => tr.cloneNode(true));

						const filterEls = {
							keyword: document.getElementById("filterKeyword"),
							status:  document.getElementById("filterStatus"),
							reset:   document.getElementById("resetFilterPosts"),
							limit:   document.getElementById("limitSelect"),
							sort:    document.getElementById("sortSelect")
						};

						function applyFilter() {
							const kw = (filterEls.keyword?.value || "").trim().toLowerCase();
							const st = (filterEls.status?.value  || "").toLowerCase();

							const filtered = originalRows.filter(tr => {
							const tds = tr.querySelectorAll("td");
							if (tds.length < 2) return false;

							// cột 0: ID, cột 1: Tiêu đề + slug (small)
							const idText    = tds[0].innerText.toLowerCase();
							const titleCell = tds[1].innerText.toLowerCase();
							const rowStatus = (tr.dataset.status || "").toLowerCase();

							const matchKw = !kw || idText.includes(kw) || titleCell.includes(kw);
							const matchSt = !st || rowStatus === st;

							return matchKw && matchSt;
							});

							tableBody.innerHTML = filtered.length
							? filtered.map(tr => tr.outerHTML).join("")
							: `<tr><td colspan="9" class="text-center text-muted">Không tìm thấy kết quả phù hợp</td></tr>`;
						}

						// Lắng nghe thay đổi filter
						[filterEls.keyword, filterEls.status].forEach(el => {
							el?.addEventListener("input", applyFilter);
							el?.addEventListener("change", applyFilter);
						});

						// Nút reset
						filterEls.reset?.addEventListener("click", (e) => {
							e.preventDefault();
							if (filterEls.keyword) filterEls.keyword.value = "";
							if (filterEls.status)  filterEls.status.value  = "";
							if (filterEls.limit)   filterEls.limit.value   = "10";
							if (filterEls.sort)    filterEls.sort.value    = "asc";

							tableBody.innerHTML = originalRows.map(tr => tr.outerHTML).join("");
							// Làm sạch URL params (nếu có)
							window.location.href = window.location.origin + window.location.pathname;
						});

						// ==================================================
						// 📄 PHÂN TRANG (giữ nguyên logic server-side)
						// ==================================================
						function goToPage(newPage) {
							newPage = Math.max(1, Math.min(newPage, TOTAL_PAGES));
							const params = new URLSearchParams(window.location.search);
							params.set("page",  newPage);
							params.set("limit", filterEls.limit?.value || 10);
							params.set("sort",  filterEls.sort?.value  || "asc");
							window.location.href = `${window.location.pathname}?${params.toString()}`;
						}

						document.querySelectorAll(".pagination .page-link").forEach(link => {
							link.addEventListener("click", e => {
							e.preventDefault();
							const li = link.closest(".page-item");
							if (li.classList.contains("disabled") || li.classList.contains("active")) return;

							let newPage = CURRENT_PAGE;
							switch (link.dataset.action) {
								case "first": newPage = 1; break;
								case "prev":  newPage--;  break;
								case "next":  newPage++;  break;
								case "last":  newPage = TOTAL_PAGES; break;
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
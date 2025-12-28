<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Cài đặt hệ thống";
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
						<!--end col-->
					</div>
					<div class="card">
						<!-- ================= HEADER ================= -->
						<div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
							<h4 class="card-title mb-0 text-uppercase fw-semibold">
								<?php echo $title; ?>
							</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table align-middle table-hover">
									<thead class="table-light">
										<tr>
											<th style="width: 60px;">#</th>
											<th style="width: 200px;">Key</th>
											<th>Value</th>
											<th style="width: 250px;">Preview</th>
											<th style="width: 80px;" class="text-center">Hành động</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$rows = $ketnoi->get_list("SELECT * FROM `options` ORDER BY `id` ASC");
											if (empty($rows)) {
												echo '<tr><td colspan="5" class="text-muted py-3 text-center">Không có dữ liệu</td></tr>';
											} else {
												foreach ($rows as $row) {
													$id = $row['id'];
													$key = ($row['key']);
													$value = ($row['value']);
													$inputType = "text";
											
													// Phân loại kiểu hiển thị
													if (filter_var($value, FILTER_VALIDATE_URL)) {
														$inputType = "url";
													} elseif (filter_var($value, FILTER_VALIDATE_EMAIL)) {
														$inputType = "email";
													} elseif (
														stripos($key, 'pass') !== false ||
														stripos($key, 'secret') !== false ||
														stripos($key, 'token') !== false
													) {
														$inputType = "password";
													}
											
													echo "<tr data-id='{$id}' data-type='{$inputType}'>
														<td>{$id}</td>
														<td><span class='fw-semibold text-primary'>{$key}</span></td>
														<td>";
											
													// Nếu là password → thêm nút show/hide
													if ($inputType === "password") {
														echo "<div class='input-group input-group-sm'>
																<input type='password' class='form-control option-input' name='{$key}' value='{$value}' autocomplete='off'>
																<button class='btn btn-outline-secondary btn-toggle-pass' type='button' title='Hiển thị mật khẩu'>
																	<i class='fas fa-eye'></i>
																</button>
															</div>";
													} else {
														echo "<input type='{$inputType}' class='form-control form-control-sm option-input' name='{$key}' value='{$value}' autocomplete='off'>";
													}
											
													// Thêm nút xóa ở cuối
													echo "</td>
														<td class='preview-cell'></td>
														<td class='text-center'>
															<button class='btn btn-outline-danger btn-sm btn-delete-option' 
																data-id='{$id}' data-key='{$key}' title='Xóa cấu hình'>
																<i class='fas fa-trash-alt'></i>
															</button>
														</td>
													</tr>";
												}
											}
											?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer bg-light text-end">
							<button class="btn btn-primary btn-sm" id="btnSaveOptionsFooter">
							<i class="fas fa-save me-1"></i> Lưu thay đổi
							</button>
						</div>
					</div>
				</div>
				<!--end card--> 
				<?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
			</div>
		</div>
		<script>
			document.addEventListener('DOMContentLoaded', () => {

				// ================================
				// 🖼 Xử lý upload ảnh cấu hình
				// ================================
				document.querySelectorAll('tbody tr').forEach(row => {
					const input = row.querySelector('.option-input');
					if (!input) return;
					const key = input.name.toLowerCase();

					// 💡 Nếu key có chứa logo, banner, favicon, image, background
					if (/(logo|banner|favicon|image|background)/i.test(key)) {
						const uploadBtn = document.createElement('button');
						uploadBtn.type = 'button';
						uploadBtn.className = 'btn btn-outline-secondary btn-sm ms-2';
						uploadBtn.innerHTML = '<i class="fas fa-upload me-1"></i> Tải ảnh';
						uploadBtn.title = 'Tải ảnh mới lên máy chủ';

						const fileInput = document.createElement('input');
						fileInput.type = 'file';
						fileInput.accept = 'image/*';
						fileInput.hidden = true;

						input.parentElement.append(uploadBtn, fileInput);

						// 🎯 Khi click → mở chọn file
						uploadBtn.addEventListener('click', () => fileInput.click());

						// 📤 Khi người dùng chọn ảnh
						fileInput.addEventListener('change', async () => {
							if (!fileInput.files.length) return;
							const file = fileInput.files[0];

							// ✅ Kiểm tra định dạng ảnh
							if (!/\.(jpg|jpeg|png|gif|webp)$/i.test(file.name)) {
								showAlert3('error', 'Lỗi', 'Vui lòng chọn tệp ảnh hợp lệ (jpg, png, gif, webp)');
								return;
							}

							uploadBtn.disabled = true;
							uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Đang tải...';

							const formData = new FormData();
							formData.append('action', 'UPLOAD_OPTION_IMAGE');
							formData.append('key', key);
							formData.append('file', file);

							try {
								const res = await fetch('/ajax/admin/settings.php', { method: 'POST', body: formData });
								const result = await res.json();

								if (result.status === 'success') {
									const url = result.data?.url || result.url || '';
									if (url) {
										input.value = url;
										const previewCell = row.querySelector('.preview-cell');
										updatePreview('url', url, previewCell);
										showAlert3('success', 'Tải ảnh thành công', 'Ảnh đã được cập nhật');
									}
								} else {
									showAlert3('error', 'Lỗi tải ảnh', result.message || 'Không thể lưu ảnh');
								}
							} catch {
								showAlert3('error', 'Kết nối thất bại', 'Không thể tải ảnh lên máy chủ');
							} finally {
								uploadBtn.disabled = false;
								uploadBtn.innerHTML = '<i class="fas fa-upload me-1"></i> Tải ảnh';
							}
						});
					}
				});

				// ================================
				// 🧩 Khởi tạo dữ liệu và preview
				// ================================
				const saveAllBtn = document.getElementById('btnSaveOptionsFooter');
				const rows = document.querySelectorAll('tbody tr');
				const originalData = {};
				const apiSettings = '/ajax/admin/settings.php';

				document.querySelectorAll('.option-input').forEach(input => {
					originalData[input.name] = input.value.trim();
				});

				rows.forEach(row => {
					const input = row.querySelector('.option-input');
					const previewCell = row.querySelector('.preview-cell');
					const type = row.dataset.type;
					updatePreview(type, input.value, previewCell);
					input.addEventListener('input', () => updatePreview(type, input.value, previewCell));
				});

				// 🎨 Hàm cập nhật preview
				function updatePreview(type, value, cell) {
					if (!cell) return;
					value = value.trim();

					if (!value) {
						cell.innerHTML = '<span class="text-muted small">Không có dữ liệu</span>';
						return;
					}

					if (type === 'url') {
						if (/\.(jpg|jpeg|png|gif|webp)$/i.test(value)) {
							cell.innerHTML = `<img src="${value}" class="img-thumbnail" style="max-width:120px;">`;
						} else {
							cell.innerHTML = `<a href="${value}" target="_blank" class="text-decoration-none text-primary">
								<i class="fas fa-external-link-alt me-1"></i> Mở liên kết
							</a>`;
						}
					} else if (type === 'email') {
						cell.innerHTML = `<a href="mailto:${value}" class="text-decoration-none text-success">
							<i class="fas fa-envelope me-1"></i>${value}
						</a>`;
					} else if (type === 'password') {
						cell.innerHTML = `<span class="text-muted">${'*'.repeat(Math.min(value.length, 8))}</span>`;
					} else {
						cell.innerHTML = `<span class="text-muted small">${value.substring(0, 50)}</span>`;
					}
				}

				// ================================
				// 👁 Toggle mật khẩu
				// ================================
				document.querySelectorAll('.btn-toggle-pass').forEach(btn => {
					btn.addEventListener('click', () => {
						const input = btn.closest('.input-group').querySelector('input');
						const icon = btn.querySelector('i');
						const isHidden = input.type === 'password';
						input.type = isHidden ? 'text' : 'password';
						icon.classList.toggle('fa-eye');
						icon.classList.toggle('fa-eye-slash');
						btn.title = isHidden ? 'Ẩn mật khẩu' : 'Hiển thị mật khẩu';
					});
				});

				// ================================
				// 💾 Lưu toàn bộ cấu hình
				// ================================
				saveAllBtn.addEventListener('click', async () => {
					const inputs = document.querySelectorAll('.option-input');
					const changedData = {};

					inputs.forEach(input => {
						const current = input.value.trim();
						if (current !== originalData[input.name]) changedData[input.name] = current;
					});

					if (Object.keys(changedData).length === 0) {
						showAlert3('info', 'Không có thay đổi', 'Không có dữ liệu mới cần lưu.');
						return;
					}

					const confirm = await Swal.fire({
						icon: 'question',
						title: 'Xác nhận lưu thay đổi?',
						html: `<small class="text-muted">Phát hiện ${Object.keys(changedData).length} mục đã được chỉnh sửa.</small>`,
						showCancelButton: true,
						confirmButtonText: 'Lưu ngay',
						cancelButtonText: 'Hủy',
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33'
					});
					if (!confirm.isConfirmed) return;

					try {
						const res = await fetch(apiSettings, {
							method: 'POST',
							headers: {'Content-Type': 'application/x-www-form-urlencoded'},
							body: new URLSearchParams({
								action: 'UPDATE_OPTIONS',
								data: JSON.stringify(changedData)
							})
						});
						const result = await res.json();

						if (result.status === 'success') {
							showAlert3('success', 'Thành công', result.message);
							Object.assign(originalData, changedData);
						} else {
							showAlert3('error', 'Lỗi', result.message);
						}
					} catch {
						showAlert3('error', 'Kết nối thất bại', 'Không thể gửi dữ liệu lên máy chủ!');
					}
				});

				// ================================
				// 🗑 Xóa cấu hình
				// ================================
				document.addEventListener('click', e => {
					const btn = e.target.closest('.btn-delete-option');
					if (!btn) return;

					const { id, key } = btn.dataset;

					Swal.fire({
						title: `Xóa cấu hình "${key}"?`,
						text: "Thao tác này không thể hoàn tác!",
						icon: "warning",
						showCancelButton: true,
						confirmButtonText: "Xóa ngay",
						cancelButtonText: "Hủy",
						confirmButtonColor: "#e3342f"
					}).then(async (result) => {
						if (!result.isConfirmed) return;
						try {
							const res = await fetch(apiSettings, {
								method: 'POST',
								headers: {'Content-Type': 'application/x-www-form-urlencoded'},
								body: new URLSearchParams({
									action: 'DELETE_OPTION',
									id: id
								})
							});
							const data = await res.json();

							if (data.status === 'success') {
								showAlert3('success', 'Thành công', data.message, 2000, () => location.reload());
							} else {
								showAlert3('error', 'Thất bại', data.message);
							}
						} catch {
							showAlert3('error', 'Lỗi kết nối', 'Không thể gửi yêu cầu xóa!');
						}
					});
				});

			});
		</script>
 		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
	</body>
</html>
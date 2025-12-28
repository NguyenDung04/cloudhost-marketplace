<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Quản lý người dùng";
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
					$total_records = $ketnoi->num_rows("SELECT * FROM `users`");
					
					// Tổng số trang
					$total_pages = ceil($total_records / $limit);
					
					// Lấy dữ liệu theo trang + sắp xếp
					$rows = $ketnoi->get_list("SELECT * FROM `users` $orderBy LIMIT $offset, $limit");
					
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
					<!-- ================= FILTER USERS ================= -->
					<div class="card-body">
						<form id="filterUsersForm" class="row g-3 align-items-center flex-wrap justify-content-between">
							<!-- ID -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-hashtag text-primary"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterId" placeholder="ID user">
								</div>
							</div>
							<!-- Fullname -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-user text-success"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterFullname" placeholder="Họ tên">
								</div>
							</div>
							<!-- Email -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-envelope text-info"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterEmail" placeholder="Email">
								</div>
							</div>
							<!-- Phone -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-phone text-warning"></i></span>
									<input type="text" class="form-control py-2 fs-6" id="filterPhone" placeholder="Số điện thoại">
								</div>
							</div>
							<!-- Band Status -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-ban text-danger"></i></span>
									<select class="form-select py-2 fs-6" id="filterBand">
										<option value="">Trạng thái Band</option>
										<option value="0">Hoạt động</option>
										<option value="1">Bị Band</option>
									</select>
								</div>
							</div>
							<!-- Level -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-user-shield text-primary"></i></span>
									<select class="form-select py-2 fs-6" id="filterLevel">
										<option value="">Cấp độ</option>
										<option value="0">Người dùng</option>
										<option value="1">Quản trị viên</option>
									</select>
								</div>
							</div>
							<!-- tb_email Status -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-envelope-open text-success"></i></span>
									<select class="form-select py-2 fs-6" id="filterTbEmail">
										<option value="">Kích hoạt Email</option>
										<option value="on">ON</option>
										<option value="off">OFF</option>
									</select>
								</div>
							</div>
							<!-- tb_tele Status -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fab fa-telegram text-info"></i></span>
									<select class="form-select py-2 fs-6" id="filterTbTele">
										<option value="">Kích hoạt Telegram</option>
										<option value="on">ON</option>
										<option value="off">OFF</option>
									</select>
								</div>
							</div>
							<!-- veri_email Status -->
							<div class="col-auto flex-fill">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-check-circle text-warning"></i></span>
									<select class="form-select py-2 fs-6" id="filterVeriEmail">
										<option value="">Xác thực Email</option>
										<option value="on">ON</option>
										<option value="off">OFF</option>
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
					<!-- ================= BẢNG QUẢN LÝ USERS ================= -->
					<div class="card-body pt-0">
						<div class="table-responsive">
							<table class="table table-striped mb-0">
								<thead class="table-light align-middle">
									<tr>
										<th><i class="fas fa-hashtag me-1 text-muted"></i>ID</th>
										<th><i class="fas fa-user me-1 text-primary"></i>Username</th>
										<th><i class="fas fa-envelope me-1 text-info"></i>Email</th>
										<th><i class="fas fa-phone me-1 text-success"></i>Phone</th>
										<th><i class="fas fa-money-bill-wave me-1 text-warning"></i>Tổng tiền</th>
										<th><i class="fas fa-user-shield me-1 text-primary"></i>Level</th>
										<th><i class="fas fa-ban me-1 text-danger"></i>Band</th>
										<th><i class="fas fa-network-wired me-1 text-secondary"></i>IP</th>
										<th><i class="fas fa-envelope-open me-1 text-success"></i>TB Email</th>
										<th><i class="fab fa-telegram me-1 text-info"></i>TB Tele</th>
										<th><i class="fas fa-check-circle me-1 text-warning"></i>Veri Email</th>
										<th><i class="fas fa-cogs me-1 text-dark"></i>Hành động</th>
									</tr>
								</thead>
								<tbody id="usersTableBody">
									<?php if (!empty($rows)): ?>
									<?php foreach ($rows as $row): ?>
									<tr data-id="<?= $row['id'] ?>"
										data-fullname="<?= ($row['fullname']) ?>"
										data-username="<?= ($row['username']) ?>"
										data-email="<?= ($row['email']) ?>"
										data-phone="<?= ($row['phone']) ?>"
										data-money="<?= $row['money'] ?>"
										data-total-money="<?= $row['total_money'] ?>"
										data-level="<?= $row['level'] ?>"
										data-band="<?= $row['band'] ?>"
										data-ip-adr="<?= ($row['ip_adr']) ?>"
										data-address="<?= ($row['address']) ?>"
										data-tb-email="<?= $row['tb_email'] ?>"
										data-tb-tele="<?= $row['tb_tele'] ?>"
										data-id-tele="<?= ($row['id_tele']) ?>"
										data-token="<?= ($row['token']) ?>"
										data-veri-otp="<?= ($row['veri_otp']) ?>"
										data-veri-email="<?= $row['veri_email'] ?>"
										data-createdate="<?= $row['createdate'] ?>"
										data-time="<?= $row['time'] ?>">
										<!-- ID -->
										<td class="fw-semibold"><?= $row['id'] ?></td>
										<!-- Username -->
										<td class="fw-semibold text-primary"> 
											<span class="badge bg-primary-subtle text-primary"><?= ($row['username']) ?></span>
										</td>
										<!-- Email -->
										<td>  
											<span class="badge bg-success-subtle text-success"><?= ($row['email']) ?></span>
										</td>
										<!-- Phone -->
										<td> 
											<span class="badge bg-info-subtle text-info"><?= ($row['phone']) ?></span>
										</td>
										<!-- Total Money -->
										<td class="fw-bold text-warning">
											<?= money($row['total_money']) ?> đ
										</td>
										<!-- Level -->
										<td>
											<?php if ($row['level'] == 1): ?> 
											<span class="badge bg-transparent border border-primary text-primary">Admin</span>
											<?php else: ?> 
											<span class="badge bg-transparent border border-secondary text-secondary">User</span>
											<?php endif; ?>
										</td>
										<!-- Band -->
										<td>
											<div class="form-check form-switch">
												<input class="form-check-input band-toggle" type="checkbox" 
													data-id="<?= $row['id'] ?>" 
													<?= $row['band'] == 1 ? 'checked' : '' ?>>
											</div>
										</td>
										<!-- IP Address -->
										<td> 
											<span class="badge bg-danger-subtle text-danger"><?= ($row['ip_adr']) ?></span> 
										</td>
										<!-- tb_email -->
										<td>
											<div class="form-check form-switch">
												<input class="form-check-input toggle-status" 
													type="checkbox" 
													data-id="<?= $row['id'] ?>"
													<?= $row['tb_email'] === 'on' ? 'checked' : '' ?>>
											</div>
										</td>
										</td>
										<!-- tb_tele -->
										<td>
											<div class="form-check form-switch">
												<input class="form-check-input toggle-status" 
													type="checkbox" 
													data-id="<?= $row['id'] ?>"
													<?= $row['tb_tele'] === 'on' ? 'checked' : '' ?>>
											</div>
										</td>
										<!-- veri_email -->
										<td>
											<div class="form-check form-switch">
												<input class="form-check-input toggle-status" 
													type="checkbox" 
													data-id="<?= $row['id'] ?>"
													<?= $row['veri_email'] === 'on' ? 'checked' : '' ?>>
											</div>
										</td>
										<!-- Actions -->
										<td class="text-center">
											<!-- Edit Button -->
											<button class="btn btn-sm btn-primary btn-edit-user me-1" 
												type="button"
												title="Sửa thông tin"
												data-id="<?= $row['id'] ?>"
												data-username="<?= htmlspecialchars($row['username']) ?>"
												data-bs-toggle="modal"
												data-bs-target="#editUserModal_<?= $row['id'] ?>"> 
												<i class="fas fa-pen-to-square me-1"></i> Sửa
											</button>
											
											<!-- Adjust Money Button -->
											<button class="btn btn-sm btn-warning btn-adjust-money" 
												type="button"
												title="Thêm/Trừ tiền"
												data-id="<?= $row['id'] ?>"
												data-username="<?= ($row['username']) ?>"
												data-current-money="<?= $row['money'] ?>"
												data-total-money="<?= $row['total_money'] ?>"
												data-bs-toggle="modal"
												data-bs-target="#adjustMoneyModal_<?= $row['id'] ?>"> 
												<i class="fas fa-money-bill-wave me-1"></i> Tiền
											</button>
										</td>
									</tr>

									<!-- Modal Edit User -->
									<div class="modal fade" id="editUserModal_<?= $row['id'] ?>" tabindex="-1"
										aria-labelledby="editUserModalLabel_<?= $row['id'] ?>" aria-hidden="true">
										<div class="modal-dialog modal-lg modal-dialog-centered">
											<div class="modal-content border-0 shadow-lg rounded-3">
												<div class="modal-header bg-primary text-white">
													<h5 class="modal-title fw-semibold" id="editUserModalLabel_<?= $row['id'] ?>">
														<i class="fas fa-user-edit me-2"></i>Sửa thông tin user #<?= $row['id'] ?> - <?= $row['username'] ?>
													</h5>
													<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
												</div>
												<form class="editUserForm" data-id="<?= $row['id'] ?>">
													<div class="modal-body p-4">
														<div class="row g-3">
															<!-- Fullname -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Họ tên</label>
																<input type="text" class="form-control" name="fullname"
																	value="<?= ($row['fullname']) ?>">
															</div>
															<!-- Email -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Email</label>
																<input type="email" class="form-control" name="email"
																	value="<?= ($row['email']) ?>">
															</div>
															<!-- Phone -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Số điện thoại</label>
																<input type="text" class="form-control" name="phone"
																	value="<?= ($row['phone']) ?>">
															</div>
															<!-- Money -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Số dư hiện tại</label>
																<input type="number" class="form-control" name="money" readonly
																	value="<?= $row['money'] ?>">
															</div>
															<!-- Total Money -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Tổng tiền đã nạp</label>
																<input type="number" class="form-control" name="total_money" readonly
																	value="<?= $row['total_money'] ?>">
															</div>
															<!-- IP Address -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Địa chỉ IP</label>
																<input type="text" class="form-control" name="ip_adr" readonly
																	value="<?= ($row['ip_adr']) ?>">
															</div>
															<!-- Address -->
															<div class="col-md-12">
																<label class="form-label fw-semibold">Địa chỉ</label>
																<textarea class="form-control" name="address" rows="2"><?= ($row['address']) ?></textarea>
															</div> 
															<!-- ID Telegram -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">ID Telegram</label>
																<input type="text" class="form-control" name="id_tele" readonly
																	value="<?= ($row['id_tele']) ?>">
															</div>
															<!-- Token -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Token</label>
																<input type="text" class="form-control" name="token" readonly
																	value="<?= ($row['token']) ?>">
															</div>
															<!-- Veri OTP -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Veri OTP</label>
																<input type="text" class="form-control" name="veri_otp" readonly
																	value="<?= ($row['veri_otp']) ?>">
															</div> 
															<!-- Level -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Level</label>
																<select class="form-select" name="level">
																	<option value="0" <?= $row['level'] == 0 ? 'selected' : '' ?>>Người dùng</option>
																	<option value="1" <?= $row['level'] == 1 ? 'selected' : '' ?>>Quản trị viên</option>
																</select>
															</div> 
															<!-- Created Date -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Ngày tạo</label>
																<input type="text" class="form-control" name="createdate"
																	value="<?= fmDate($row['createdate']) ?>" readonly>
															</div>
															<!-- Last Update Time -->
															<div class="col-md-6">
																<label class="form-label fw-semibold">Cập nhật lần cuối</label>
																<input type="text" class="form-control" name="time"
																	value="<?= fmDate($row['time']) ?>" readonly>
															</div>
														</div>
													</div>
													<div class="modal-footer bg-light"> 
														<button type="submit" class="btn btn-warning fw-semibold">
															<i class="fas fa-save me-1"></i>Cập nhật
														</button>
													</div>
												</form>
											</div>
										</div>
									</div>

									<!-- Modal Adjust Money --> 
									<div class="modal fade" id="adjustMoneyModal_<?= $row['id'] ?>" tabindex="-1" aria-labelledby="adjustMoneyModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-warning text-white">
													<h5 class="modal-title" id="adjustMoneyModalLabel">
														<i class="fas fa-money-bill-wave me-2"></i>
														Quản lý tiền người dùng #<?= $row['id'] ?> - <?= $row['username'] ?>
													</h5>
													<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body">
													<!-- User Info -->
													<div class="alert alert-info">
														<div class="d-flex justify-content-between"> 
															<div class="text-end">
																<strong>Số dư hiện tại:</strong>  
																<span class="badge bg-primary-subtle text-primary"><?= money($row['money']) ?> đ</span>
															</div>
														</div>
														<div class="mt-2">
															<strong>Tổng nạp:</strong>  
															<span class="badge bg-success-subtle text-success"><?= money($row['total_money']) ?> đ</span>
														</div>
														<!-- Hidden values for JS -->
														<input type="hidden" id="currentMoneyValue_<?= $row['id'] ?>" value="<?= $row['money'] ?>">
														<input type="hidden" id="currentTotalMoneyValue_<?= $row['id'] ?>" value="<?= $row['total_money'] ?>">
														<input type="hidden" id="userName_<?= $row['id'] ?>" value="<?= $row['username'] ?>">
													</div>
													
													<!-- Form -->
													<form id="adjustMoneyForm_<?= $row['id'] ?>">
														<input type="hidden" id="adjustUserIdInput_<?= $row['id'] ?>" name="user_id" value="<?= $row['id'] ?>">
														<input type="hidden" id="actionTypeInput_<?= $row['id'] ?>" name="action_type" value="add">
														
														<!-- Amount -->
														<div class="mb-3">
															<label for="amount_<?= $row['id'] ?>" class="form-label fw-semibold">
																<i class="fas fa-coins me-1"></i>
																Số tiền (VND)
															</label>
															<div class="input-group">
																<input type="number" class="form-control" id="amount_<?= $row['id'] ?>" name="amount" 
																	min="1000" step="1000" placeholder="Nhập số tiền" required>
																<span class="input-group-text">đ</span>
															</div>
															<div class="form-text">Số tiền tối thiểu: 1,000đ</div>
														</div>
														
														<!-- Action Type -->
														<div class="mb-1">
															<label class="form-label fw-semibold">
																<i class="fas fa-exchange-alt me-1"></i>
																Loại giao dịch
															</label>
															<div class="row g-2">
																<div class="col-6">
																	<button type="button" class="btn btn-success w-100 py-2 action-type-btn" 
																		data-action="add" data-modal-id="<?= $row['id'] ?>" id="addBtn_<?= $row['id'] ?>">
																		<i class="fas fa-plus-circle fa-2x mb-2"></i><br>
																		<span class="fw-bold">THÊM TIỀN</span><br>
 																	</button>
																</div>
																<div class="col-6">
																	<button type="button" class="btn btn-outline-danger w-100 py-2 action-type-btn" 
																		data-action="subtract" data-modal-id="<?= $row['id'] ?>" id="subtractBtn_<?= $row['id'] ?>">
																		<i class="fas fa-minus-circle fa-2x mb-2"></i><br>
																		<span class="fw-bold">TRỪ TIỀN</span><br>
 																	</button>
																</div>
															</div>
														</div>
														
														<!-- Preview changes -->
														<div class="alert alert-warning" id="previewChanges_<?= $row['id'] ?>" style="display: none;">
															<h6><i class="fas fa-eye me-1"></i> Xem trước thay đổi:</h6>
															<div class="mt-2">
																<div class="row">
																	<div class="col-6">
																		<strong>Money mới:</strong><br>
																		<span id="newMoneyPreview_<?= $row['id'] ?>">0</span> đ
																	</div>
																	<div class="col-6">
																		<strong>Total_money mới:</strong><br>
																		<span id="newTotalMoneyPreview_<?= $row['id'] ?>">0</span> đ
																	</div>
																</div>
															</div>
														</div>
													</form>
												</div>
												<div class="modal-footer"> 
													<button type="button" class="btn btn-warning" id="submitAdjustMoney_<?= $row['id'] ?>">
														<i class="fas fa-check me-1"></i> Xác nhận
													</button>
												</div>
											</div>
										</div>
									</div>

									<?php endforeach; ?>
									<?php else: ?>
									<tr>
										<td colspan="12" class="text-center text-muted py-4">
											<i class="fas fa-users fa-2x mb-3"></i><br>
											Không có dữ liệu người dùng
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
					
						const urlApi = "/ajax/admin/user_manager.php";  	
 
						// Xử lý click nút loại giao dịch (Thêm/Trừ)
						document.addEventListener("click", function(e) {
							if (e.target.closest(".action-type-btn")) {
								const button = e.target.closest(".action-type-btn");
								const modalId = button.getAttribute("data-modal-id");
								const action = button.getAttribute("data-action");
								
								// Cập nhật input hidden
								document.getElementById(`actionTypeInput_${modalId}`).value = action;
								
								// Reset trạng thái của cả hai nút
								const addBtn = document.getElementById(`addBtn_${modalId}`);
								const subtractBtn = document.getElementById(`subtractBtn_${modalId}`);
								
								addBtn.classList.remove("btn-success");
								addBtn.classList.add("btn-outline-success");
								subtractBtn.classList.remove("btn-danger");
								subtractBtn.classList.add("btn-outline-danger");
								
								// Set trạng thái active cho nút được chọn
								if (action === "add") {
									button.classList.remove("btn-outline-success");
									button.classList.add("btn-success");
								} else {
									button.classList.remove("btn-outline-danger");
									button.classList.add("btn-danger");
								}
							}
						});

						// Xử lý submit form điều chỉnh tiền
						document.addEventListener("click", async (e) => {
							if (e.target.closest("[id^='submitAdjustMoney_']")) {
								e.preventDefault();
								
								const button = e.target.closest("[id^='submitAdjustMoney_']");
								const modalId = button.id.split("_")[1];
								const form = document.getElementById(`adjustMoneyForm_${modalId}`);
								
								// Lấy dữ liệu từ form
								const fd = new FormData(form);
								fd.append("action", "ADJUST_MONEY");
								
								// Kiểm tra dữ liệu
								const amount = fd.get("amount");
								if (!amount || amount <= 0) {
									showAlert3(
										"error",
										"Lỗi",
										"Vui lòng nhập số tiền hợp lệ (lớn hơn 0)!"
									);
									return;
								}
								
								try {
									const res = await fetch(urlApi, {
										method: "POST",
										body: fd
									});
									const data = await res.json();
									
									if (data.status === "success") {
										showAlert3(
											"success",
											"Thành công",
											data.message || "Điều chỉnh tiền thành công!",
											1500,
											() => {
												// Đóng modal
												const modalEl = document.getElementById(`adjustMoneyModal_${modalId}`);
												const modal = bootstrap.Modal.getInstance(modalEl);
												if (modal) modal.hide();
												
												// Reload trang để cập nhật dữ liệu
												location.reload();
											}
										);
									} else {
										showAlert3(
											"error",
											"Lỗi",
											data.message || "Không thể điều chỉnh tiền!"
										);
									}
								} catch (error) {
									console.error("Error:", error);
									showAlert3(
										"error",
										"Kết nối thất bại",
										"Không thể gửi yêu cầu lên máy chủ!"
									);
								}
							}
						});

						document.addEventListener("submit", async e => {
							const form = e.target.closest(".editUserForm");
							if (!form) return;
					
							e.preventDefault();
							const id = form.dataset.id; 
							
							const fd = new FormData(form);
							fd.append("id", id);
							fd.append("action", "EDIT_USER"); 
					
							try {
								const res = await fetch(urlApi, {
									method: "POST",
									body: fd
								});
								const data = await res.json();
					
								if (data.status === "success") {
									showAlert3("success", "Thành công", data.message || "Cập nhật thành công!", 1500, () => {
										location.reload();
									});
									bootstrap.Modal.getInstance(form.closest(".modal"))?.hide();
								} else {
									showAlert3("error", "Lỗi", data.message || "Không thể cập nhật người dùng!");
								}
							} catch {
								showAlert3("error", "Kết nối thất bại", "Không thể gửi yêu cầu lên máy chủ!");
							}
						});
					
						// ==================================================
						// 🟡 CẬP NHẬT UNBAN OR BAN
						// ==================================================
						document.addEventListener("change", async e => {
							const bandToggle = e.target.closest(".band-toggle");
							if (!bandToggle) return;
					
							const id = bandToggle.dataset.id;
							const newStatus = bandToggle.checked ? "1" : "0";
							const action = bandToggle.checked ? "ban" : "unban";
					
							// Xác nhận đơn giản
							const confirm = await Swal.fire({
								title: `Bạn có chắc muốn ${action}?`,
								icon: 'warning',
								showCancelButton: true,
								confirmButtonText: 'Đồng ý',
								cancelButtonText: 'Hủy'
							});
					
							if (!confirm.isConfirmed) {
								bandToggle.checked = !bandToggle.checked;
								return;
							}
					
							// Xử lý AJAX
							bandToggle.disabled = true;
							
							try {
								const formData = new FormData();
								formData.append("action", "UPDATE_BAND_STATUS");
								formData.append("id", id);
								formData.append("band", newStatus);
					
								const res = await fetch(urlApi, {
									method: "POST",
									body: formData
								});
					
								const data = await res.json();
					
								if (data.status === "success") { 
									showAlert3("success", "Thành công", `Đã ${action} thành công`);
									// Cập nhật UI nếu cần
								} else { 
									showAlert3("error", "Lỗi", data.msg || "Không thể cập nhật trạng thái!");
									bandToggle.checked = !bandToggle.checked;
								}
							} catch (error) {
								showAlert3("error", "Lỗi kết nối", "Không thể gửi yêu cầu!");
								bandToggle.checked = !bandToggle.checked;
							} finally {
								bandToggle.disabled = false;
							}
						});
						
						// ==================================================
						// 🔍 FILTER CARD HISTORY 
						// ==================================================  
						const tableBody = document.getElementById("usersTableBody");
					
						if (tableBody) {
							// Clone toàn bộ row ban đầu
							const originalRows = Array.from(tableBody.querySelectorAll("tr")).map(tr => tr.cloneNode(true));
					
							// Filter elements
							const filters = {
								id: document.getElementById("filterId"),
								fullname: document.getElementById("filterFullname"),
								email: document.getElementById("filterEmail"),
								phone: document.getElementById("filterPhone"),
								band: document.getElementById("filterBand"),
								level: document.getElementById("filterLevel"),
								tb_email: document.getElementById("filterTbEmail"),
								tb_tele: document.getElementById("filterTbTele"),
								veri_email: document.getElementById("filterVeriEmail"),
								reset: document.getElementById("resetFilter"),
								limit: document.getElementById("limitSelect"),
								sort: document.getElementById("sortSelect"),
							};
					
							// Apply filter function
							function applyFilter() {
								const values = {
									id: filters.id?.value.trim().toLowerCase() || "",
									fullname: filters.fullname?.value.trim().toLowerCase() || "",
									email: filters.email?.value.trim().toLowerCase() || "",
									phone: filters.phone?.value.trim().toLowerCase() || "",
									band: filters.band?.value || "",
									level: filters.level?.value || "",
									tb_email: filters.tb_email?.value || "",
									tb_tele: filters.tb_tele?.value || "",
									veri_email: filters.veri_email?.value || ""
								};
					
								const filtered = originalRows.filter(tr => {
									if (tr.querySelector('td[colspan]')) return true;
					
									const data = {
										id: tr.dataset.id?.toString().toLowerCase() || "",
										fullname: tr.dataset.fullname?.toLowerCase() || "",
										email: tr.dataset.email?.toLowerCase() || "",
										phone: tr.dataset.phone?.toString().toLowerCase() || "",
										band: tr.dataset.band?.toString() || "",
										level: tr.dataset.level?.toString() || "",
										tb_email: tr.dataset.tbEmail?.toString() || "",
										tb_tele: tr.dataset.tbTele?.toString() || "",
										veri_email: tr.dataset.veriEmail?.toString() || ""
									};
					
									// ID filter
									if (values.id && !data.id.includes(values.id)) return false;
									
									// Fullname filter
									if (values.fullname && !data.fullname.includes(values.fullname)) return false;
									
									// Email filter
									if (values.email && !data.email.includes(values.email)) return false;
									
									// Phone filter
									if (values.phone && !data.phone.includes(values.phone)) return false;
									
									// Band filter
									if (values.band !== "" && data.band !== values.band) return false;
									
									// Level filter
									if (values.level !== "" && data.level !== values.level) return false;
									
									// tb_email filter (lọc theo trạng thái checkbox hiện tại)
									if (values.tb_email !== "") {
										const tbEmailCheckbox = tr.querySelector('td:nth-child(9) .form-check-input');
										const isTbEmailChecked = tbEmailCheckbox ? tbEmailCheckbox.checked : false;
										
										if (values.tb_email === 'on' && !isTbEmailChecked) return false;
										if (values.tb_email === 'off' && isTbEmailChecked) return false;
									}
									
									// tb_tele filter (lọc theo trạng thái checkbox hiện tại)
									if (values.tb_tele !== "") {
										const tbTeleCheckbox = tr.querySelector('td:nth-child(10) .form-check-input');
										const isTbTeleChecked = tbTeleCheckbox ? tbTeleCheckbox.checked : false;
										
										if (values.tb_tele === 'on' && !isTbTeleChecked) return false;
										if (values.tb_tele === 'off' && isTbTeleChecked) return false;
									}
									
									// veri_email filter (lọc theo trạng thái checkbox hiện tại)
									if (values.veri_email !== "") {
										const veriEmailCheckbox = tr.querySelector('td:nth-child(11) .form-check-input');
										const isVeriEmailChecked = veriEmailCheckbox ? veriEmailCheckbox.checked : false;
										
										if (values.veri_email === 'on' && !isVeriEmailChecked) return false;
										if (values.veri_email === 'off' && isVeriEmailChecked) return false;
									}			
									
									return true;
								});
					
								// Update table
								tableBody.innerHTML = filtered.length > 0 
									? filtered.map(tr => tr.outerHTML).join("")
									: `<tr><td colspan="12" class="text-center text-muted py-4">
										<i class="fas fa-search fa-2x mb-3"></i><br>
										Không tìm thấy kết quả phù hợp
									</td></tr>`;
							}
					
							// Attach events
							Object.values(filters).forEach(el => {
								if (el && el !== filters.reset) {
									el.addEventListener(el.type === 'text' ? 'input' : 'change', applyFilter);
								}
							});
					
							// Reset filter
							if (filters.reset) {
								filters.reset.addEventListener("click", e => {
									e.preventDefault();
									Object.values(filters).forEach(el => {
										if (el && el !== filters.reset) el.value = "";
									});
					
									// Reset limit và sort (nếu có)
									if (filters.limit) filters.limit.value = "10";
									if (filters.sort) filters.sort.value = "asc";
					
									tableBody.innerHTML = originalRows.map(tr => tr.outerHTML).join("");
					
									// Không reload trang, chỉ reset local
									window.location.href = window.location.origin + window.location.pathname;
								});
							}
					
							// Initial filter
							applyFilter();
						}

						// ==================================================
						// 🧭 PHÂN TRANG + LỌC CLIENT-SIDE
						// ==================================================
						const TOTAL_PAGES = <?= (int)$total_pages ?>;
						const CURRENT_PAGE = <?= (int)$page ?>;
						const CURRENT_LIMIT = <?= (int)$limit ?>;
						const CURRENT_SORT = '<?= addslashes($sort) ?>';

						// ================== PHÂN TRANG ==================
						function goToPage(newPage) {
							newPage = Math.max(1, Math.min(newPage, TOTAL_PAGES));
							const params = new URLSearchParams(window.location.search);

							// Lấy các tham số hiện tại từ URL hoặc dùng giá trị mặc định từ PHP
							const limit = params.get('limit') || CURRENT_LIMIT;
							const sort = params.get('sort') || CURRENT_SORT;

							params.set("page", newPage);
							params.set("limit", limit);
							params.set("sort", sort);

							window.location.href = `${window.location.pathname}?${params.toString()}`;
						}

						// Sự kiện click phân trang
						document.addEventListener('DOMContentLoaded', function() {
							const paginationLinks = document.querySelectorAll(".pagination .page-link[data-action]");
							
							paginationLinks.forEach(link => {
								link.addEventListener("click", function(e) {
									e.preventDefault();
									
									const li = this.closest(".page-item");
									if (li.classList.contains("disabled")) return;
									
									let newPage = CURRENT_PAGE;
									
									switch (this.dataset.action) {
										case "first": newPage = 1; break;
										case "prev": newPage = Math.max(1, CURRENT_PAGE - 1); break;
										case "next": newPage = Math.min(TOTAL_PAGES, CURRENT_PAGE + 1); break;
										case "last": newPage = TOTAL_PAGES; break;
									}
									
									// Chỉ chuyển trang nếu khác trang hiện tại
									if (newPage !== CURRENT_PAGE) {
										goToPage(newPage);
									}
								});
							});

							// Xử lý click vào số trang (các nút số)
							document.querySelectorAll(".pagination .page-link:not([data-action])").forEach(link => {
								link.addEventListener("click", function(e) {
									const li = this.closest(".page-item");
									if (li.classList.contains("active")) {
										e.preventDefault();
									}
									// Nếu không active, để href mặc định hoạt động
								});
							});
						});

						// ================== XỬ LÝ THAY ĐỔI LIMIT & SORT ==================
						// (Nếu bạn có dropdown để thay đổi limit và sort)
						document.addEventListener('DOMContentLoaded', function() {
							// Xử lý thay đổi limit nếu có dropdown
							const limitSelect = document.getElementById('limit-select');
							if (limitSelect) {
								limitSelect.value = CURRENT_LIMIT; // Đặt giá trị hiện tại
								limitSelect.addEventListener('change', function() {
									const params = new URLSearchParams(window.location.search);
									params.set('limit', this.value);
									params.set('page', 1); // Reset về trang 1 khi thay đổi limit
									window.location.href = `${window.location.pathname}?${params.toString()}`;
								});
							}

							// Xử lý thay đổi sort nếu có dropdown
							const sortSelect = document.getElementById('sort-select');
							if (sortSelect) {
								sortSelect.value = CURRENT_SORT; // Đặt giá trị hiện tại
								sortSelect.addEventListener('change', function() {
									const params = new URLSearchParams(window.location.search);
									params.set('sort', this.value);
									params.set('page', 1); // Reset về trang 1 khi thay đổi sort
									window.location.href = `${window.location.pathname}?${params.toString()}`;
								});
							}
						});
					});
				</script>
				<?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
			</div>
		</div>
		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
	</body>
</html>
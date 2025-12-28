<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
	<head>
		<?php
			$title = "Dashboard";
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
					<div id="dashboard" class="row justify-content-center"></div>
					<script>
						document.addEventListener("DOMContentLoaded", () => {
						  const dashboardContainer = document.getElementById("dashboard");
						
						  // Hiển thị loading khi chờ API
						  dashboardContainer.innerHTML = `
						    <div class="text-center py-5">
						      <div class="spinner-border text-primary" role="status"></div>
						      <p class="mt-2 text-muted">Đang tải dữ liệu dashboard...</p>
						    </div>
						  `;
						
						  // Gọi API chuẩn AJAX
						  fetch("https://localhost/api/dashboard.php")
						    .then((response) => response.json())
						    .then((res) => {
						      // Kiểm tra chuẩn cấu trúc JSON
						      if (res.status === "success" && Array.isArray(res.data)) {
						        dashboardContainer.innerHTML = ""; // Xóa loading
						        res.data.forEach((config) => createStatCard(config)); // Render từng card
						      } else {
						        showError(res.message || "Không thể tải dữ liệu dashboard!");
						      }
						    })
						    .catch((err) => {
						      console.error("Lỗi khi gọi API:", err);
						      showError("Không thể kết nối tới máy chủ!");
						    });
						
						  // Hàm hiển thị lỗi
						  function showError(msg) {
						    dashboardContainer.innerHTML = `
						      <div class="alert alert-danger text-center w-100" role="alert">
						        <i class="fas fa-exclamation-triangle"></i> ${msg}
						      </div>
						    `;
						  }
						
						  // ====================
						  // HÀM TẠO CARD DÙNG CHUNG (giữ nguyên từ bản của bạn)
						  // ==================== 
						
						function createStatCard(config) {
							const { id, title, iconSet, data } = config;
							const hasMultiple = Object.keys(data).length > 1;
						
							const card = document.createElement("div");
							card.className = "col-md-6 col-lg-3 mb-1";
							card.innerHTML = `
							<div class="card shadow-sm border-0" id="card-${id}">
								<div class="card-body">
								<div class="d-flex justify-content-between align-items-start mb-2">
									<p class="fw-semibold text-dark mb-1">${title}</p>
									${hasMultiple ? `
									<div class="dropdown">
									<button class="btn btn-sm btn-light border dropdown-toggle" type="button"
										id="timeSelect-${id}" data-bs-toggle="dropdown" aria-expanded="false">
										Ngày
									</button>
									<ul class="dropdown-menu dropdown-menu-end" id="timeMenu-${id}">
										${data.day ? `<li><a class="dropdown-item active" href="#" data-type="day">Ngày</a></li>` : ""}
										${data.month ? `<li><a class="dropdown-item" href="#" data-type="month">Tháng</a></li>` : ""}
										${data.year ? `<li><a class="dropdown-item" href="#" data-type="year">Năm</a></li>` : ""}
										${data.total ? `<li><a class="dropdown-item" href="#" data-type="total">Tổng tất cả</a></li>` : ""}
									</ul>
									</div>` : ""}
								</div>
						
								<div class="d-flex justify-content-between align-items-center">
									<div>
									<h3 class="mb-0 fw-bold text-dark" id="valueNumber-${id}">0</h3>
									<small id="valueChange-${id}" class="text-muted">
										<i class="fas fa-spinner fa-spin"></i> Đang cập nhật...
									</small>
									</div>  
									<div class="icon-circle d-flex align-items-center justify-content-center">
										<i id="valueIcon-${id}" class="fas fa-chart-bar fs-4 text-success"></i>
									</div>
								</div>
								</div>
							</div>
							`;
						
							dashboardContainer.appendChild(card);
						
							const valueNumber = card.querySelector(`#valueNumber-${id}`);
							const valueChange = card.querySelector(`#valueChange-${id}`);
							const valueIcon = card.querySelector(`#valueIcon-${id}`);
							const menuItems = hasMultiple ? card.querySelectorAll(`#timeMenu-${id} .dropdown-item`) : [];
							const selectBtn = hasMultiple ? card.querySelector(`#timeSelect-${id}`) : null;
						
							// Hàm kiểm tra nếu value là số hay chuỗi đã format
							function parseValue(val) {
								// Nếu là chuỗi chứa chữ (K, M, B, VNĐ) -> giữ nguyên chuỗi
								if (typeof val === 'string' && /[a-zA-ZĐ]/.test(val)) {
									return { type: 'string', value: val };
								}
								// Nếu là số -> convert thành số
								const num = Number(val);
								return { type: 'number', value: num };
							}
						
							function animateCountUp(start, end, duration = 800) {
								const range = end - start;
								let startTime = null;
								function step(currentTime) {
									if (!startTime) startTime = currentTime;
									const progress = Math.min((currentTime - startTime) / duration, 1);
									const currentValue = Math.floor(start + range * progress);
									valueNumber.textContent = currentValue.toLocaleString();
									if (progress < 1) requestAnimationFrame(step);
								}
								requestAnimationFrame(step);
							}
						
							function updateCard(type) {
								const item = data[type];
								if (!item) return;
								
								const parsedValue = parseValue(item.value);
								
								if (parsedValue.type === 'number') {
									// Nếu là số, thực hiện animation
									const oldVal = parseInt(valueNumber.textContent.replace(/,/g, "")) || 0;
									animateCountUp(oldVal, parsedValue.value);
								} else {
									// Nếu là chuỗi đã format, hiển thị trực tiếp
									valueNumber.textContent = parsedValue.value;
								}
								
								valueChange.innerHTML = `<i class="las la-arrow-up text-${item.color}"></i> ${item.change}`;
								valueChange.className = `text-${item.color}`;
								valueIcon.className = `${iconSet[type] || iconSet.total} fs-4`;
						
								if (hasMultiple && selectBtn) {
									menuItems.forEach((i) => i.classList.remove("active"));
									const active = card.querySelector(`[data-type='${type}']`);
									if (active) active.classList.add("active");
									selectBtn.textContent = active ? active.textContent : "Tổng";
								}
							}
						
							if (hasMultiple) {
								menuItems.forEach((item) => {
									item.addEventListener("click", (e) => {
										e.preventDefault();
										updateCard(e.target.dataset.type);
									});
								});
								updateCard("day");
							} else {
								updateCard("total");
							}
						} 
						});
					</script>
				</div>
				<?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
			</div>
		</div>
		<?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
	</body>
</html>
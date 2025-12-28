<script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/libs/simplebar/simplebar.min.js"></script>
<script src="/assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>
<script src="/assets/js/pages/index.init.js"></script>
<script src="/assets/js/app.js"></script>
<script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script> 
<script src="https://mannatthemes.com/dastone-bs5/default/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<div id="uiBlocker" style="display:none;
	position:fixed;
	top:0; left:0; width:100%; height:100%;
	background:rgba(0,0,0,0.5);
	z-index:2000;
	backdrop-filter: blur(3px);">
	<div style="display:flex;align-items:center;justify-content:center;height:100%;">
		<div style="text-align:center;color:white;">
			<img src="/core/upload/images/loading.gif" 
				alt="Đang xử lý..."
				style="width:100px;height:100px;animation:pulse 1.2s infinite;">
			<h5 style="margin-top:10px;">Đang xử lý thanh toán...</h5>
		</div>
	</div>
	<style>
		@keyframes pulse {
		0%,100% { transform: scale(1); opacity: 0.9; }
		50% { transform: scale(1.1); opacity: 1; }
		}
	</style>
</div>
<script>
	// ============================
	// 🧩 SweetAlert2 dùng chung có đếm ngược
	// ============================
	function showAlert3(type = "info", title = "Thông báo", message = "", duration = 3000, onClose = null) {
		let timerInterval;
	
		Swal.fire({
			icon: type,
			title: title,
			html: `
				<div class="fw-semibold">${message}</div>
				<small class="text-muted d-block mt-2">
					Tự đóng sau <b class="countdown">${Math.ceil(duration / 1000)}</b> giây...
				</small>
			`,
			showConfirmButton: false,
			timer: duration,
			timerProgressBar: true,
			allowOutsideClick: true,
			didOpen: () => {
				const countdownEl = Swal.getHtmlContainer().querySelector(".countdown");
				timerInterval = setInterval(() => {
					const remaining = Math.ceil(Swal.getTimerLeft() / 1000);
					countdownEl.textContent = remaining;
				}, 200);
			},
			willClose: () => clearInterval(timerInterval)
		}).then(result => {
			if (typeof onClose === "function") {
				onClose(result);
			}
		});
	}
	
	function showAlert(title = '', text = '', icon = '') {
	       Swal.fire({
	           title: title,
	           text: text,
	           icon: icon,
	           confirmButtonText: 'OK',
	           customClass: {
	               confirmButton: 'btn btn-primary'
	               },
	           buttonsStyling: false
	       });
	   }
	
	// Validate email
	function validateEmail(email) {
		if (!email) return true; // Cho phép rỗng
		const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		return re.test(email);
	}
	
	// Validate phone (Việt Nam)
	function validatePhone(phone) {
		if (!phone) return true; // Cho phép rỗng
		const cleanPhone = phone.replace(/\D/g, '');
		const re = /^(0|84)(3[2-9]|5[6|8|9]|7[0|6-9]|8[1-9]|9[0-9])[0-9]{7}$/;
		return re.test(cleanPhone);
	}
	
	// Format phone number
	function formatPhoneNumber(phone) {
		if (!phone) return '';
		const cleanPhone = phone.replace(/\D/g, '');
		if (cleanPhone.length === 10) {
			return cleanPhone.replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3');
		} else if (cleanPhone.length === 11) {
			return cleanPhone.replace(/(\d{3})(\d{3})(\d{5})/, '$1 $2 $3');
		}
		return phone;
	}
	
</script>
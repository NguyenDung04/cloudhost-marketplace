<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <title>Quản lý VPS| APIIT</title>
      <?php
         $id = antixss($_GET['id']);
         $check = $ketnoi->get_row("SELECT * FROM `purchased_cloudvps` WHERE `id_vps` = '$id' AND `username` = '$username'");
         if(!$check){
            header("Location: /404");
            exit();
         }
         $id_product = $check['id_produc'];
         $product = $ketnoi->get_row("SELECT * FROM `package_cloudvps` WHERE `product_id` = '$id_product'");
         $info = json_decode($check['info'], true);
         $data = json_decode($check['data'],true);
         ?>
   </head>
   <body>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/nav.php';?>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/sidebar.php';?>
      <div class="startbar-overlay d-print-none"></div>
      <div class="page-wrapper">
      <div class="page-content">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                     <h4 class="page-title">Quản lý VPS</h4>
                     <div class="">
                        <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                        <a href="/home"><i class="fa-solid fa-house me-1"></i> Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                        <a href="/client/historys/vps"><i class="fa-solid fa-receipt me-1"></i> Lịch sử mua VPS</a>
                        </li>
                        <li class="breadcrumb-item active">
                        <i class="fa-solid fa-server me-1"></i> Quản lý VPS
                        </li>
                        </ol>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row justify-content-center">
               <!-- Card 1: Cấu hình VPS -->
               <div class="col-md-6">
                  <div class="card mb-4 shadow-sm">
                     <div class="card-header bg-primary text-white">
                        <i class="fa-solid fa-server me-2"></i> Cấu hình VPS
                     </div>
                     <div class="card-body">
                        <form id="vpsConfigForm">
                           <div class="row">
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">Tên VPS</label>
                                 <input type="text" class="form-control"  value="<?=$product['name'];?>" disabled>
                              </div>
                              <div class="col-md-8 mb-3">
                                 <label class="form-label">Hệ Điều Hành</label>
                                 <input type="text" class="form-control" value="<?=$info[0]['vps_os'];?>" disabled>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">CPU</label>
                                 <input type="number" class="form-control"  value="<?=$data['cpu'];?>" disabled>
                              </div>
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">RAM (GB)</label> 
                                 <input type="number" class="form-control" value="<?=$data['ram'];?>" disabled>
                              </div>
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">Dung lượng (GB)</label>
                                 <input type="number" class="form-control"  value="<?=$data['disk'];?>" disabled>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">Ngày tạo</label>
                                 <input type="text" class="form-control"  value="<?=fmDate($check['created_at']);?>" disabled>
                              </div>
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">Ngày hết hạn</label>
                                 <input type="text" class="form-control"  value="<?=fmDate($check['end_date']);?>" disabled>
                              </div>
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">Giá </label>
                                 <input type="text" class="form-control"  value="<?=money($check['total_money']);?>đ" disabled>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <!-- Card 2: Thông tin VPS -->
               <div class="col-md-6">
                  <div class="card mb-4 shadow-sm">
                     <div class="card-header bg-success text-white">
                        <i class="fa-solid fa-network-wired me-2"></i> Thông tin truy cập VPS
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Email</label>
                              <input type="email" class="form-control" value="<?=$user['email'];?>" disabled>
                           </div>
                           <div class="col-md-3 mb-3">
                              <label class="form-label">Trạng thái</label>
                              <button type="button" class="form-control btn btn-outline-success"><?=status_vps($check['status']);?></button>
                           </div>
                        </div>
                        <div class="mb-3">
                           <label class="form-label">Địa chỉ IP</label>
                           <input type="text" class="form-control"  readonly value="<?=$info[0]['ip'];?>">
                        </div>
                        <div class="row">
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Tài khoản</label>
                              <input type="text" class="form-control" id="username" readonly value="<?=$info[0]['username'];?>">
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Mật khẩu</label>
                              <div class="input-group">
                                 <input type="password" class="form-control" id="password" readonly value="<?=$data['password'];?>">
                                 <button class="btn btn-outline-secondary" type="button" id="togglePass" aria-label="Hiện mật khẩu" title="Hiện mật khẩu">
                                 <i class="fa-solid fa-eye" id="togglePassIcon"></i>
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Card 3: Thao tác -->
               <div class="col-md-12">
                  <div class="card shadow-sm">
                     <div class="card-header bg-dark text-white">
                        <i class="fa-solid fa-server me-2"></i> Quản lý VPS
                     </div>
                     <div class="card-body">
                        <ul class="nav nav-tabs mb-3" id="vpsTabs">
                           <li class="nav-item">
                              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabChucNang">Chức năng</button>
                           </li>
                           <li class="nav-item">
                              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabCaiLai">Cài lại hệ điều hành</button>
                           </li>
                        </ul>
                        <div class="tab-content">
                           <!-- Tab Chức năng -->
                           <!-- Tab Chức năng -->
                           <div class="tab-pane fade show active" id="tabChucNang">
                              <div class="row g-3 text-center">
                                 <!-- Start -->
                                 <div class="col-md-2">
                                    <button class="btn btn-light w-100 py-3 border shadow-sm" data-bs-toggle="modal" data-bs-target="#modalStart">
                                    <i class="fa-solid fa-play fa-lg text-success mb-2"></i><br>
                                    <strong>Start</strong>
                                    </button>
                                 </div>
                                 <!-- Reboot -->
                                 <div class="col-md-2">
                                    <button class="btn btn-light w-100 py-3 border shadow-sm" data-bs-toggle="modal" data-bs-target="#modalReboot">
                                    <i class="fa-solid fa-rotate-right fa-lg text-primary mb-2"></i><br>
                                    <strong>Reboot</strong>
                                    </button>
                                 </div>
                                 <!-- Shut Down -->
                                 <div class="col-md-2">
                                    <button class="btn btn-light w-100 py-3 border shadow-sm" data-bs-toggle="modal" data-bs-target="#modalShutdown">
                                    <i class="fa-solid fa-stop fa-lg text-danger mb-2"></i><br>
                                    <strong>Shut Down</strong>
                                    </button>
                                 </div>
                                 <!-- Nâng cấp -->
                                 <div class="col-md-2">
                                    <button class="btn btn-light w-100 py-3 border shadow-sm" data-bs-toggle="modal" data-bs-target="#modalUpgrade">
                                    <i class="fa-solid fa-arrow-up fa-lg text-info mb-2"></i><br>
                                    <strong>Nâng cấp</strong>
                                    </button>
                                 </div>
                                 <!-- Gia hạn -->
                                 <div class="col-md-2">
                                    <button class="btn btn-light w-100 py-3 border shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRenew">
                                    <i class="fa-solid fa-clock fa-lg text-warning mb-2"></i><br>
                                    <strong>Gia hạn</strong>
                                    </button>
                                 </div>
                                 <!-- Đổi quản trị -->
                                 <div class="col-md-2">
                                    <button class="btn btn-light w-100 py-3 border shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTransfer">
                                    <i class="fa-solid fa-right-left fa-lg text-secondary mb-2"></i><br>
                                    <strong>Đổi quản trị</strong>
                                    </button>
                                 </div>
                              </div>
                              <!-- 🟢 Modal: Start -->
                              <div class="modal fade" id="modalStart" tabindex="-1">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h6 class="modal-title fw-bold">Bật VPS</h6>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                       </div>
                                       <div class="modal-body">
                                          Bạn có chắc chắn muốn <strong>bật</strong> VPS này không?
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                          <button type="button" class="btn btn-success" id="btnStart">Xác nhận</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- 🔄 Modal: Reboot -->
                              <div class="modal fade" id="modalReboot" tabindex="-1">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h6 class="modal-title fw-bold">Khởi động lại VPS</h6>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                       </div>
                                       <div class="modal-body">
                                          Bạn có chắc chắn muốn <strong>khởi động lại</strong> VPS này không?
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                          <button type="button" class="btn btn-primary" id="btnRestart">Xác nhận</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="modal fade" id="modalShutdown" tabindex="-1">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h6 class="modal-title fw-bold">Tắt VPS</h6>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                       </div>
                                       <div class="modal-body">
                                          Bạn có chắc chắn muốn <strong>tắt VPS</strong> này không?
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                          <button type="button" class="btn btn-danger" id="btnStop">Xác nhận</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- ⬆️ Modal: Nâng cấp -->
                              <!-- Modal Nâng cấp VPS -->
                              <div class="modal fade" id="modalUpgrade" tabindex="-1" aria-labelledby="modalUpgradeLabel" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                       <div class="modal-header">
                                          <h6 class="modal-title fw-bold" id="modalUpgradeLabel">Nâng cấp VPS</h6>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                       </div>
                                       <div class="modal-body">
                                          <form id="upgradeForm">
                                             <div class="mb-3">
                                                <label class="form-label">CPU Thêm (CORE):</label>
                                                <input type="number" class="form-control" id="cpuAdd" min="0" value="0">
                                             </div>
                                             <div class="mb-3">
                                                <label class="form-label">RAM Thêm (GB):</label>
                                                <input type="number" class="form-control" id="ramAdd" min="0" value="0">
                                             </div>
                                             <div class="mb-3">
                                                <label class="form-label">DISK Thêm (1 đơn vị = 10GB):</label>
                                                <input type="number" class="form-control" id="diskAdd" min="0" value="0">
                                             </div>
                                             <div class="mb-2">
                                                <label class="form-label">Thanh toán:</label><br>
                                                <strong id="totalCost">0 VNĐ</strong>
                                             </div>
                                          </form>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                          <button type="button" class="btn btn-primary" id="btnConfirmUpgrade">Xác nhận</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="modal fade" id="modalRenew" tabindex="-1" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow-lg border-0 rounded-3">
                                       <div class="modal-header bg-warning bg-opacity-10">
                                          <h6 class="modal-title fw-bold text-warning">
                                             <i class="fa-solid fa-clock-rotate-left me-1"></i> Gia hạn VPS
                                          </h6>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                       </div>
                                       <div class="modal-body">
                                          <p class="mb-3 text-muted">
                                             Vui lòng chọn <strong>thời gian gia hạn</strong> cho VPS này. Giá sẽ được tính tự động dựa trên chu kỳ.
                                          </p>
                                          <div class="mb-3">
                                             <label class="form-label fw-semibold">Chọn thời gian gia hạn</label>
                                             <select id="renewCycle" class="form-select">
                                                <option value="" disabled selected>-- Chọn chu kỳ --</option>
                                                <option value="monthly">1 Tháng</option>
                                                <option value="twomonthly">2 Tháng</option>
                                                <option value="quarterly">3 Tháng</option>
                                                <option value="semi_annually">6 Tháng</option>
                                                <option value="annually">1 Năm</option>
                                                <option value="biennially">2 Năm</option>
                                                <option value="triennially">3 Năm</option>
                                             </select>
                                          </div>
                                          <div class="border rounded-3 p-3 bg-light">
                                             <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="fw-semibold text-muted">Giá cơ bản:</span>
                                                <span id="basePrice" class="fw-bold text-dark"><?=money($check['total_money']);?>đ</span>
                                             </div>
                                             <hr class="my-2">
                                             <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Tổng thanh toán:</span>
                                                <span id="totalPrice" class="fw-bold text-danger fs-5">0đ</span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                          <i class="fa-solid fa-xmark me-1"></i> Hủy
                                          </button>
                                          <button type="button" class="btn btn-warning fw-semibold" id="renewVps">
                                          <i class="fa-solid fa-rotate me-1" ></i> Xác nhận gia hạn
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                            <!-- Modal Chuyển quyền quản trị VPS -->
<div class="modal fade" id="modalTransfer" tabindex="-1">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow">
         <div class="modal-header">
            <h6 class="modal-title fw-bold">
               <i class="fa-solid fa-right-left me-1"></i> Chuyển quyền quản trị VPS
            </h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body">
            <label for="emailTransfer" class="form-label">Email nhận quyền:</label>
            <input type="email" class="form-control mb-3" id="emailTransfer" placeholder="Nhập email cần chuyển">

            <div class="alert alert-info border-info mt-3 mb-0 text-start" role="alert">
                                             <i class="fa-solid fa-coins me-2 text-warning"></i>
                                             <strong>Phí chuyển quyền:</strong> <span class="fw-semibold text-dark">1.000đ</span><br>
                                             Phí này sẽ được trừ trực tiếp từ số dư tài khoản của bạn khi hoàn tất giao dịch.
                                          </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
               <i class="fa-solid fa-xmark me-1"></i> Thoát
            </button>
            <button type="button" class="btn btn-primary" id="btnConfirmChangeUser">
               <i class="fa-solid fa-share-from-square me-1"></i> Xác nhận
            </button>
         </div>
      </div>
   </div>
</div>
                           </div>
                           <!-- Tab Cài lại Hệ điều hành -->
                           <div class="tab-pane fade" id="tabCaiLai">
                              <!-- Thông báo -->
                              <div class="alert alert-warning d-flex align-items-center" role="alert">
                                 <i class="fa-solid fa-circle-info me-2"></i>
                                 <div>
                                    <strong>Lưu ý:</strong> Chức năng cài lại hệ điều hành VPS sẽ đưa VPS về trạng thái ban đầu và xóa toàn bộ dữ liệu cũ.
                                 </div>
                              </div>
                              <!-- Danh sách hệ điều hành -->
                              <h6 class="fw-bold mb-3">Chọn hệ điều hành:</h6>
                              <div class="row g-3">
                              <?php foreach($ketnoi->get_list("SELECT * FROM `img_os`") as $os): ?>
                              <div class="col-md-3">
                              <div class="card os-option text-center border shadow-sm h-100"
                                    data-id="<?=$os['id'];?>"
                                    data-name="<?=$os['os_name'];?>">
                                 <div class="card-body">
                                    <img src="<?=$os['image_url'];?>" alt="<?=$os['os_name'];?>" width="50" class="mb-2">
                                    <div><?=$os['os_name'];?></div>
                                 </div>
                              </div>
                              </div>
                              <?php endforeach; ?>
                              </div>
                              <div class="mt-4 text-end">
                                 <button class="btn btn-primary px-4 py-2" id="btnInstall" disabled>
                                 <i class="fa-solid fa-download me-2"></i> Cài lại ngay
                                 </button>
                              </div>
                              <!-- Modal Cài đặt lại hệ điều hành -->
                              <div class="modal fade" id="modalReinstall" tabindex="-1" aria-labelledby="modalReinstallLabel" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                       <div class="modal-header bg-danger text-white">
                                          <h6 class="modal-title fw-bold" id="modalReinstallLabel">
                                             <i class="fa-solid fa-triangle-exclamation me-1"></i> Xác nhận cài đặt lại
                                          </h6>
                                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                       </div>
                                       <div class="modal-body">
                                          <p class="mb-2">
                                             Bạn sắp <strong>cài đặt lại hệ điều hành</strong> cho VPS này. 
                                             Quá trình này sẽ <span class="text-danger fw-bold">xóa toàn bộ dữ liệu hiện có</span> và khôi phục VPS về trạng thái ban đầu.
                                          </p>
                                          <div class="alert alert-warning py-2 mb-3">
                                             <i class="fa-solid fa-circle-info me-1"></i>
                                             Hệ điều hành được chọn: <strong id="selectedOSName">Chưa chọn</strong>
                                          </div>
                                          <p class="text-muted small mb-0">
                                             ⚠️ Hãy đảm bảo bạn đã sao lưu dữ liệu trước khi tiếp tục!
                                          </p>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                          <button type="button" class="btn btn-danger" id="btnConfirmReinstall">
                                          <i class="fa-solid fa-rotate me-1"></i> Xác nhận cài lại
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <script>
                  document.addEventListener("DOMContentLoaded", function() {
                  const renewCycle = document.getElementById("renewCycle");
                  const basePriceEl = document.getElementById("basePrice");
                  const totalPriceEl = document.getElementById("totalPrice");

                  const basePriceText = basePriceEl.textContent.replace(/[^\d]/g, ''); 
                  const basePrice = parseInt(basePriceText) || 0;

                  const cycleMultiplier = {
                     'monthly': 1,
                     'twomonthly': 2,
                     'quarterly': 3,
                     'semi_annually': 6,
                     'annually': 12,
                     'biennially': 24,
                     'triennially': 36
                  };
                  renewCycle.addEventListener('change', function() {
                     const cycle = this.value;
                     const months = cycleMultiplier[cycle] || 0;
                     let total = basePrice * months;
                     let discount = 0;         
                     const discountAmount = total * discount;
                     total -= discountAmount;
                     const formatted = total.toLocaleString('vi-VN') + 'đ';
                     totalPriceEl.textContent = formatted;
                  });
               });
                  document.addEventListener("DOMContentLoaded", function () {
                  const osCards = document.querySelectorAll(".os-option");
                  const btnInstall = document.getElementById("btnInstall");
                  const selectedOSName = document.getElementById("selectedOSName");
                  let selectedOS = null;
                  osCards.forEach(card => {
                      card.addEventListener("click", function () {
                      osCards.forEach(c => c.classList.remove("active"));
                      this.classList.add("active");
                      selectedOS = this.querySelector("div").innerText.trim();
                      btnInstall.disabled = false;
                      });
                  });
                  btnInstall.addEventListener("click", function () {
                      if (!selectedOS) {
                      alert("Vui lòng chọn hệ điều hành trước khi cài đặt lại!");
                      return;
                      }
                      selectedOSName.textContent = selectedOS;
                      const modal = new bootstrap.Modal(document.getElementById("modalReinstall"));
                      modal.show();
                  });
                  });
                  document.addEventListener("DOMContentLoaded", function() {
                      const osCards = document.querySelectorAll(".os-option");
                      const btnInstall = document.getElementById("btnInstall");
                      let selectedOS = null;
                      osCards.forEach(card => {
                          card.addEventListener("click", function() {
                          osCards.forEach(c => c.classList.remove("active"));
                          this.classList.add("active");
                          selectedOS = this.getAttribute("data-os");
                          btnInstall.disabled = false;
                          });
                      });
                  });
                    document.getElementById('togglePass').addEventListener('click', function() {
                       const pass = document.getElementById('password');
                       const icon = this.querySelector('i');
                       if (pass.type === 'password') {
                          pass.type = 'text';
                          icon.classList.replace('fa-eye', 'fa-eye-slash');
                       } else {
                          pass.type = 'password';
                          icon.classList.replace('fa-eye-slash', 'fa-eye');
                       }
                    });
               </script>
               <style>
                  .os-option {
                  cursor: pointer;
                  border-radius: 10px;
                  transition: all 0.25s ease;
                  }
                  .os-option:hover {
                  border-color:rgb(13, 205, 253);
                  transform: translateY(-3px);
                  box-shadow: 0 0 10px rgba(13, 110, 253, 0.2);
                  }
                  .os-option.active {
                  border: 2px solidrgb(252, 252, 252) !important;
                  background-color: #e8f1ff !important;
                  box-shadow: 0 0 10px rgba(13, 110, 253, 0.25);
                  }
               </style>
            </div>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
         </div>
      </div>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
      <script>
      $(document).ready(function () {
         async function handleVpsAction(btnSelector, id_vps, action_vps) {
            const $btn = $(btnSelector);
            try {
               $btn.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm align-middle me-1"></span> Đang xử lý...`);
               const res = await $.ajax({
               url: '/ajax/cloud/cloud-vps.php',
               type: 'POST',
               dataType: 'json',
               data: {
                  action: 'ACTION_VPS',
                  id_vps,
                  action_vps
               }
               });
               if (res.status === 'success') {
               showAlert('Thành công', res.msg, 'success');
               setTimeout(() => window.location.reload(), 1500);
               } else {
               showAlert('Thất bại', res.msg || 'Thao tác thất bại', 'error');
               }
            } catch (err) {
               showAlert('Thất bại', 'Lỗi kết nối máy chủ', 'error');
            } finally {
               $btn.prop('disabled', false).html(action_vps.toUpperCase());
            }
         }
         const vpsId = '<?=$check['id_vps'];?>';
         $('#btnStart').on('click', () => handleVpsAction('#btnStart', vpsId, 'on'));
         $('#btnStop').on('click', () => handleVpsAction('#btnStop', vpsId, 'off'));
         $('#btnRestart').on('click', () => handleVpsAction('#btnRestart', vpsId, 'restart'));
         let selectedOSId = null;
         let selectedOSName = null;
         $(document).on('click', '.os-option', function () {
            $('.os-option').removeClass('active border-primary shadow-lg');
            $(this).addClass('active border-primary shadow-lg');
            selectedOSId = $(this).data('id');  
            selectedOSName = $(this).data('name'); 
            console.log("Đã chọn OS:", selectedOSId, selectedOSName);

            $('#selectedOSName').text(selectedOSName);
            $('#btnInstall').prop('disabled', false);
         });
            $('#btnInstall').on('click', function () {
               if (!selectedOSId) {
                  showAlert('Thất bại', 'Vui lòng chọn hệ điều hành trước khi cài lại!', 'error');
                  return;
               }
               const modal = new bootstrap.Modal(document.getElementById('modalReinstall'));
               modal.show();
            });
            $('#btnConfirmReinstall').on('click', async function () {
               const $btn = $(this);
               const id_vps = <?=$check['id_vps'];?>;
               if (!selectedOSId) {
                  showAlert('Thất bại', 'Bạn chưa chọn hệ điều hành!', 'error');
                  return;
               }
               try {
                  $btn.prop('disabled', true)
                     .html('<span class="spinner-border spinner-border-sm align-middle me-1"></span> Đang xử lý...');
                  const res = await $.ajax({
                  url: '/ajax/cloud/cloud-vps.php',
                  type: 'POST',
                  dataType: 'json',
                  data: {
                     action: 'REBUILD_VPS',
                     id_vps: id_vps,
                     id_os: selectedOSId
                  }
                  });
                  if (res.status === 'success') {
                  showAlert('Thành công', res.msg || 'Cài lại thành công', 'success');
                  setTimeout(() => window.location.reload(), 1500);
                  } else {
                  showAlert('Thất bại', res.msg || 'Không thể cài lại VPS', 'error');
                  }
               } catch (err) {
                  console.error(err);
                  showAlert('Thất bại', 'Lỗi kết nối máy chủ', 'error');
               } finally {
                  $btn.prop('disabled', false).html('<i class="fa-solid fa-rotate me-1"></i> Xác nhận cài lại');
               }
            });
            $btnConfirmReinstall.on('click', btnConfirmReinstall);
      });
      $(document).ready(function() {
         const $renewVps = $('#renewVps');
            const renewVps = async () => {
               try {
                  $renewVps.prop('disabled', true)
                     .html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang xử lý...');
                  const billingCycle = $('#renewCycle').val() ?? ''; 
                  if (billingCycle === '') {
                     showAlert('Thất bại', 'Vui lòng chọn chu kỳ gia hạn', 'error');
                     $renewVps.prop('disabled', false).html('Xác nhận gia hạn');
                     return;
                  }
                  const vpsId = '<?=$check['id_vps'];?>';
                  const res = await $.ajax({
                     url: '/ajax/cloud/cloud-vps.php',
                     type: 'POST',
                     dataType: 'json',
                     data: {
                        action: 'RENEW_VPS',
                        vps_id: vpsId,
                        billing_cycle: billingCycle
                     },
                  });
                  if (res.status === 'success') {
                     showAlert('Thành công', res.msg, 'success');
                     setTimeout(() => window.location.reload(), 1500);
                  } else {
                     showAlert('Thất bại', res.msg || 'Thao tác thất bại', 'error');
                  }
               } catch (err) {
                  console.error(err);
                  showAlert('Thất bại', 'Không thể kết nối máy chủ', 'error');
               } finally {
                  $renewVps.prop('disabled', false).html('Xác nhận gia hạn');
               }
            };
            $renewVps.on('click', renewVps);
         const $btnConfirmChangeUser = $('#btnConfirmChangeUser');
         const btnConfirmChangeUser = async () => {
            try {
               $btnConfirmChangeUser.prop('disabled', true)
                  .html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang xử lý...');
               const id_vps = <?=$check['id_vps'];?>;
               const email = $('#emailTransfer').val();
               const res = await $.ajax({
                  url: '/ajax/cloud/cloud-vps.php',
                  type: 'POST',
                  dataType: 'json',
                  data: {
                     action: 'CHANGE_USER',
                     id_vps:  id_vps,
                     email: email
                  }
               });
               if (res.status === 'success') {
                  showAlert('Thành công', res.msg, 'success');
                  setTimeout(() => window.location.href='/client/historys/vps', 1500);
               } else {
                  showAlert('Thất bại', res.msg || 'Thao tác thất bại', 'error');
               }  
            } catch(err){
               console.error(err);
               showAlert('Thất bại', 'Không thể kết nối máy chủ', 'error');
            } finally {
               $btnConfirmChangeUser.prop('disabled', false).html('<i class="fa-solid fa-share-from-square me-1"></i> Xác nhận');
            }
         }
         $btnConfirmChangeUser.on('click', btnConfirmChangeUser);
      });
      </script>
   </body>
</html>
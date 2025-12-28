<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/core/hosting.php';?>
      <title>Quản lý Hosting| APIIT</title>
      <?php
         $id_host = antixss($_GET['id']);
         $check = $ketnoi->get_row("SELECT * FROM `history_buy_hosting` WHERE `id` = '$id_host' AND `username` = '$username' AND `status` != 'delete_vps'");
         if(!$check){
            header("Location: /404");
            exit();
         }
         $pk_host = $check['pk_host'];
         $package_host = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `code_host` = '$pk_host'");
         $sv_host = $check['sv_host'];
         $server_host = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$sv_host'");
         ?>
      <style>
         .skel {
         background: linear-gradient(90deg, #e3e3e3 25%, #f1f1f1 50%, #e3e3e3 75%);
         background-size: 200% 100%;
         animation: skelLoad 1.2s infinite;
         border-radius: 4px;
         }
         /* Skeleton animation chung */
         @keyframes shimmer {
         0% { background-position: 200% 0; }
         100% { background-position: -200% 0; }
         }
         /* CPU - Đỏ nhạt */
         .skel-cpu {
         background: linear-gradient(90deg, #ffe1e1 25%, #fff0f0 50%, #ffe1e1 75%);
         background-size: 200% 100%;
         animation: shimmer 1.2s infinite;
         }
         /* RAM - Xanh ngọc nhạt */
         .skel-ram {
         background: linear-gradient(90deg, #d9f7f2 25%, #ecfffc 50%, #d9f7f2 75%);
         background-size: 200% 100%;
         animation: shimmer 1.2s infinite;
         }
         /* Disk - Vàng nhạt */
         .skel-disk {
         background: linear-gradient(90deg, #fff4cc 25%, #fff9e6 50%, #fff4cc 75%);
         background-size: 200% 100%;
         animation: shimmer 1.2s infinite;
         }
         /* Process - Xanh dương nhạt */
         .skel-proc {
         background: linear-gradient(90deg, #e2eaff 25%, #f1f5ff 50%, #e2eaff 75%);
         background-size: 200% 100%;
         animation: shimmer 1.2s infinite;
         }
         /* Text skeleton */
         .loading-text {
         color: transparent !important;
         background: #eaeaea;
         display: inline-block;
         width: 35px;
         height: 10px;
         border-radius: 4px;
         }
         .progress-cpu {
         background-color: #ff4d4f !important;
         }
         .progress-ram {
         background-color: #13c2c2 !important;
         }
         .progress-disk {
         background-color: #faad14 !important;
         }
         .progress-proc {
         background-color: #597ef7 !important;
         }
      </style>
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
                     <h4 class="page-title">Quản lý Hosting</h4>
                     <div class="">
                        <ol class="breadcrumb mb-0">
                           <li class="breadcrumb-item">
                              <a href="/home"><i class="fa-solid fa-house me-1"></i>Trang chủ</a>
                           </li>
                           <li class="breadcrumb-item">
                              <a href="/client/history/hosting"><i class="fa-solid fa-receipt me-1"></i> Lịch sử mua hosting</a>
                           </li>
                           <li class="breadcrumb-item active">
                              <i class="fa-solid fa-server me-1"></i> Quản lý Hosting
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
                        <i class="fa-solid fa-server me-2"></i> Cấu hình hosting (<?=$check['domain'];?>)
                     </div>
                     <div class="card-body">
                        <form id="vpsConfigForm">
                           <div class="row">
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">Tên gói</label>
                                 <input type="text" class="form-control"  value="<?=$package_host['name_host'];?>" disabled>
                              </div>
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">IP</label>
                                 <input type="text" class="form-control" value="<?=($server_host['ip_whm']);?>" disabled>
                              </div>
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">Dung lượng</label>
                                 <input type="text" class="form-control" value="<?=money($package_host['disk']);?> mb" disabled>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">Ngày tạo</label>
                                 <input type="text" class="form-control"  value="<?=fmDate($check['creatAt']);?>" disabled>
                              </div>
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">Ngày hết hạn</label>
                                 <input type="text" class="form-control"  value="<?=fmDate($check['endAt']);?>" disabled>
                              </div>
                              <div class="col-md-4 mb-3">
                                 <label class="form-label">Giá </label>
                                 <input type="text" class="form-control"  value="<?=money($check['total_money']);?>đ" disabled>
                              </div>
                           </div>
                           <div class="row">
                              <!-- CPU -->
                              <div class="col-6 mb-3">
                                 <label class="form-label small fw-bold">
                                 CPU <span id="cpu_text" class="text-muted">...</span>
                                 </label>
                                 <div class="progress" style="height: 6px;">
                                    <div id="cpu_progress" class="progress-bar skel-cpu" style="width:100%"></div>
                                 </div>
                              </div>
                              <!-- RAM -->
                              <div class="col-6 mb-3">
                                 <label class="form-label small fw-bold">
                                 RAM <span id="ram_text" class="text-muted">...</span>
                                 </label>
                                 <div class="progress" style="height: 6px;">
                                    <div id="ram_progress" class="progress-bar skel-ram" style="width:100%"></div>
                                 </div>
                              </div>
                              <!-- DISK -->
                              <div class="col-6 mb-3">
                                 <label class="form-label small fw-bold">
                                 Disk <span id="disk_text" class="text-muted">...</span>
                                 </label>
                                 <div class="progress" style="height: 6px;">
                                    <div id="disk_progress" class="progress-bar skel-disk" style="width:100%"></div>
                                 </div>
                              </div>
                              <!-- PROCESS -->
                              <div class="col-6 mb-3">
                                 <label class="form-label small fw-bold">
                                 Process <span id="process_text" class="text-muted">...</span>
                                 </label>
                                 <div class="progress" style="height: 6px;">
                                    <div id="process_progress" class="progress-bar skel-proc" style="width:100%"></div>
                                 </div>
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
                        <i class="fa-solid fa-network-wired me-2"></i> Thông tin truy cập hosting
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Email</label>
                              <input type="email" class="form-control" value="<?=$user['email'];?>" disabled>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Trạng thái</label>
                              <button type="button" class="form-control btn btn-outline-success"><?=status_vps($check['status']);?></button>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Link đăng nhập</label>
                              <input type="text" class="form-control"  readonly value="http://<?=$server_host['ip_whm'];?>:2083">
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Login Nhanh</label>
                              <button type="button" class="btn btn-primary w-100" id="btnLoginCpanel">
                                 Mở cPanel
                              </button> 
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Tài khoản</label>
                              <input type="text" class="form-control" id="username" readonly value="<?=decodecryptData($check['account']);?>">
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label">Mật khẩu</label>
                              <div class="input-group">
                                 <input type="password" class="form-control" id="password" readonly value="<?=decodecryptData($check['password']);?>">
                                 <button class="btn btn-outline-secondary" type="button" id="togglePass" aria-label="Hiện mật khẩu" title="Hiện mật khẩu">
                                 <i class="fa-solid fa-eye" id="togglePassIcon"></i>
                                 </button>
                              </div>
                           </div>
                        </div>
                        <button class="btn btn-warning w-100 mt-2" data-bs-toggle="modal" data-bs-target="#dnsGuideModal">
                           <i class="fa-solid fa-circle-info me-2"></i> Hướng dẫn trỏ domain
                        </button>
                     </div>
                  </div>
               </div>
               <!-- Modal Hướng Dẫn DNS -->
               <div class="modal fade" id="dnsGuideModal" tabindex="-1" aria-labelledby="dnsGuideModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                     <div class="modal-content shadow">
                           <div class="modal-header bg-danger text-white">
                              <h5 class="modal-title" id="dnsGuideModalLabel">
                                 <i class="fa-solid fa-globe me-2"></i> Hướng dẫn trỏ domain vào hosting
                              </h5>
                              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                           </div>
                           <div class="modal-body">
                              <p>Bạn có thể trỏ domain theo <strong>1 trong 2 cách</strong> sau:</p>
                              <div class="mb-4">
                                 <h6 class="fw-bold text-dark">Cách 1: Trỏ bằng Nameserver (Khuyến nghị)</h6>
                                 <code class="d-block mb-1"><?= $server_host['name_server1']; ?></code>
                                 <code class="d-block mb-2"><?= $server_host['name_server2']; ?></code>
                                 <small class="text-muted">Áp dụng cho mọi domain – kích hoạt hosting đầy đủ tính năng.</small>
                              </div>
                              <div class="mb-4">
                                 <h6 class="fw-bold text-dark">Cách 2: Trỏ bằng IP (A Record)</h6>
                                 <code class="d-block">A → <?= $server_host['ip_whm']; ?></code>
                                 <small class="text-muted">Phù hợp khi bạn muốn giữ nguyên NS của DNS provider.</small>
                              </div>
                              <div class="alert alert-info">
                                 <i class="fa-solid fa-clock me-2"></i> 
                                 DNS có thể mất <strong>5–15 phút</strong> để cập nhật.
                              </div>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                           </div>

                     </div>
                  </div>
               </div>
               <!-- Card 3: Thao tác -->
               <div class="col-md-12">
                  <div class="card shadow-sm">
                     <div class="card-header bg-dark text-white">
                        <i class="fa-solid fa-server me-2"></i> Quản lý hosting
                     </div>
                     <div class="card-body">
                        <ul class="nav nav-tabs mb-3" id="vpsTabs">
                           <li class="nav-item">
                              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabChucNang">Chức năng</button>
                           </li>
                        </ul>
                        <div class="tab-content">
                           <!-- Tab Chức năng -->
                           <div class="tab-pane fade show active" id="tabChucNang">
                              <div class="row g-3 text-center">
                                 <!-- 🟢 Cài lại -->
                                 <div class="col-md-2 col-6">
                                    <button class="btn btn-outline-success w-100 py-4 border-0 shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalStart">
                                    <i class="fa-solid fa-rotate-left fa-2x mb-2"></i><br>
                                    <span class="fw-semibold fs-6">Cài lại</span>
                                    </button>
                                 </div>
                                 <!-- 🔵 Đổi mật khẩu -->
                                 <div class="col-md-2 col-6">
                                    <button class="btn btn-outline-primary w-100 py-4 border-0 shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalReboot">
                                    <i class="fa-solid fa-key fa-2x mb-2"></i><br>
                                    <span class="fw-semibold fs-6">Đổi mật khẩu</span>
                                    </button>
                                 </div>
                                 <!-- 🟣 Đổi tên miền -->
                                 <div class="col-md-2 col-6">
                                    <button class="btn btn-outline-info w-100 py-4 border-0 shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalUpgrade">
                                    <i class="fa-solid fa-globe fa-2x mb-2"></i><br>
                                    <span class="fw-semibold fs-6">Đổi tên miền</span>
                                    </button>
                                 </div>
                                 <!-- 🟡 Gia hạn -->
                                 <div class="col-md-2 col-6">
                                    <button class="btn btn-outline-warning w-100 py-4 border-0 shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalRenew">
                                    <i class="fa-solid fa-clock-rotate-left fa-2x mb-2"></i><br>
                                    <span class="fw-semibold fs-6">Gia hạn</span>
                                    </button>
                                 </div>
                                 <!-- ⚙️ Đổi quản trị -->
                                 <div class="col-md-2 col-6">
                                    <button class="btn btn-outline-secondary w-100 py-4 border-0 shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalTransfer">
                                    <i class="fa-solid fa-user-gear fa-2x mb-2"></i><br>
                                    <span class="fw-semibold fs-6">Đổi quản trị</span>
                                    </button>
                                 </div>
                                 <div class="col-md-2 col-6">
                                    <button class="btn btn-outline-danger w-100 py-4 border-0 shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalDelete">
                                    <i class="fa-solid fa-trash fa-2x mb-2"></i><br>
                                    <span class="fw-semibold fs-6">Xóa Hosting</span>
                                    </button>
                                 </div>
                              </div>
                              <!-- 🟢 Modal: Start -->
                              <div class="modal fade" id="modalStart" tabindex="-1">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                       <div class="modal-header bg-danger bg-opacity-10 border-0">
                                          <h6 class="modal-title fw-bold text-danger">
                                             <i class="fa-solid fa-rotate-left me-1"></i> Cài lại hosting
                                          </h6>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                       </div>
                                       <div class="modal-body">
                                          <p class="mb-3">
                                             Bạn có chắc chắn muốn <strong>cài lại</strong> hosting này không?
                                          </p>
                                          <!-- ⚠️ Lưu ý cảnh báo -->
                                          <div class="alert alert-warning border-warning text-start" role="alert">
                                             <i class="fa-solid fa-triangle-exclamation me-2 text-danger"></i>
                                             <strong>Lưu ý:</strong> Thao tác này sẽ <span class="text-danger fw-semibold">xóa toàn bộ dữ liệu, file, cơ sở dữ liệu và cấu hình hiện tại</span> trên hosting.  
                                             Dữ liệu sau khi cài lại <u>không thể khôi phục</u>.
                                          </div>
                                       </div>
                                       <div class="modal-footer border-0">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                          <i class="fa-solid fa-xmark me-1"></i> Hủy
                                          </button>
                                          <button type="button" class="btn btn-danger fw-semibold" id="btnStart">
                                          <i class="fa-solid fa-rotate-left me-1"></i> Xác nhận cài lại
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- 🔄 Modal: Reboot -->
                              <div class="modal fade" id="modalReboot" tabindex="-1">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                       <div class="modal-header bg-primary bg-opacity-10 border-0">
                                          <h6 class="modal-title fw-bold text-primary" id="modalUpgradeLabel">
                                             <i class="fa-solid fa-key me-1"></i> Đổi mật khẩu
                                          </h6>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                       </div>
                                       <div class="modal-body">
                                          <form id="changePassForm">
                                             <div class="mb-3">
                                                <label class="form-label">Mật khẩu mới:</label>
                                                <div class="input-group">
                                                   <input type="text" class="form-control" id="newPassword" placeholder="Nhập mật khẩu mới...">
                                                   <button type="button" class="btn btn-outline-secondary" id="btnGeneratePass" title="Tạo mật khẩu ngẫu nhiên">
                                                   <i class="fa-solid fa-wand-magic-sparkles"></i>
                                                   </button>
                                                </div>
                                                <div class="form-text text-muted mt-1">
                                                   🔐 Gợi ý: Mật khẩu nên có ít nhất <strong>8 ký tự</strong>, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                       <div class="modal-footer border-0">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                          <i class="fa-solid fa-xmark me-1"></i> Thoát
                                          </button>
                                          <button type="button" class="btn btn-primary" id="btnChangePass">
                                          <i class="fa-solid fa-check me-1"></i> Xác nhận
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- ⬆️ Modal: Nâng cấp -->
                              <!-- Modal Nâng cấp VPS -->
                              <div class="modal fade" id="modalUpgrade" tabindex="-1" aria-labelledby="modalUpgradeLabel" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                       <div class="modal-header bg-info bg-opacity-10 border-0">
                                          <h6 class="modal-title fw-bold text-info" id="modalUpgradeLabel">
                                             <i class="fa-solid fa-globe me-1"></i> Đổi tên miền
                                          </h6>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                       </div>
                                       <div class="modal-body">
                                          <form id="upgradeForm">
                                             <div class="mb-3">
                                                <label class="form-label fw-semibold">Tên miền mới:</label>
                                                <input
                                                   type="text"
                                                   class="form-control"
                                                   id="domain"
                                                   placeholder="<?= $check['domain']; ?>"
                                                   autocomplete="off"
                                                   >
                                                <div class="form-text text-muted mt-1">
                                                   🌐 Nhập tên miền hợp lệ, ví dụ: <strong>example.com</strong> hoặc <strong>tenmien.vn</strong>.
                                                </div>
                                             </div>
                                          </form>
                                          <!-- ⚠️ Lưu ý -->
                                          <div class="alert alert-warning border-warning text-start mb-0" role="alert">
                                             <i class="fa-solid fa-triangle-exclamation me-2 text-danger"></i>
                                             <strong>Lưu ý:</strong> Việc đổi tên miền sẽ cập nhật cấu hình hosting.
                                             <br>Hãy đảm bảo tên miền mới đã được trỏ DNS chính xác trước khi xác nhận.
                                          </div>
                                       </div>
                                       <div class="modal-footer border-0">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                          <i class="fa-solid fa-xmark me-1"></i> Thoát
                                          </button>
                                          <button type="button" class="btn btn-primary fw-semibold" id="btnChangeDomain">
                                          <i class="fa-solid fa-check me-1"></i> Xác nhận đổi
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- ⏰ Modal: Gia hạn -->
                              <!-- Modal Gia hạn VPS -->
                              <div class="modal fade" id="modalRenew" tabindex="-1" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow-lg border-0 rounded-3">
                                       <div class="modal-header bg-warning bg-opacity-10">
                                          <h6 class="modal-title fw-bold text-warning">
                                             <i class="fa-solid fa-clock-rotate-left me-1"></i> Gia hạn hosting
                                          </h6>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                       </div>
                                       <div class="modal-body">
                                          <p class="mb-3 text-muted">
                                             Vui lòng chọn <strong>thời gian gia hạn</strong> cho Hosting này. Giá sẽ được tính tự động dựa trên chu kỳ.
                                          </p>
                                          <!-- Chọn chu kỳ gia hạn -->
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
                                          <button type="button" class="btn btn-warning fw-semibold" id="btnRenewHost">
                                          <i class="fa-solid fa-rotate me-1"></i> Xác nhận gia hạn
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- 🔁 Modal: Đổi quản trị -->
                              <div class="modal fade" id="modalTransfer" tabindex="-1">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                       <div class="modal-header bg-primary bg-opacity-10 border-0">
                                          <h6 class="modal-title fw-bold text-primary">
                                             <i class="fa-solid fa-user-gear me-1"></i> Chuyển quyền quản trị hosting
                                          </h6>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                       </div>
                                       <div class="modal-body">
                                          <label  class="form-label">Email người nhận:</label>
                                          <input type="email" class="form-control" id="email" placeholder="Nhập email cần chuyển">
                                          <!-- 💰 Thông báo phí chuyển -->
                                          <div class="alert alert-info border-info mt-3 mb-0 text-start" role="alert">
                                             <i class="fa-solid fa-coins me-2 text-warning"></i>
                                             <strong>Phí chuyển quyền:</strong> <span class="fw-semibold text-dark">1.000đ</span><br>
                                             Phí này sẽ được trừ trực tiếp từ số dư tài khoản của bạn khi hoàn tất giao dịch.
                                          </div>
                                       </div>
                                       <div class="modal-footer border-0">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                          <i class="fa-solid fa-xmark me-1"></i> Thoát
                                          </button>
                                          <button type="button" class="btn btn-primary fw-semibold" id="btnChangeUser">
                                          <i class="fa-solid fa-paper-plane me-1"></i> Xác nhận chuyển
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                       <div class="modal-header bg-danger bg-opacity-10 border-0">
                                          <h6 class="modal-title fw-bold text-danger">
                                             <i class="fa-solid fa-triangle-exclamation me-1"></i> Xóa hosting
                                          </h6>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                       </div>
                                       <div class="modal-body">
                                          <p class="mb-3">
                                             Bạn có chắc chắn muốn <strong class="text-danger">xóa gói hosting</strong> này không?
                                          </p>
                                          <div class="alert alert-danger border-danger text-start" role="alert">
                                             <i class="fa-solid fa-circle-exclamation me-2"></i>
                                             <strong>Cảnh báo nghiêm trọng!</strong><br>
                                             Thao tác này sẽ <span class="fw-semibold text-danger">xóa vĩnh viễn toàn bộ dữ liệu</span> của hosting bao gồm:
                                             <ul class="mt-2 mb-0">
                                                <li>Tất cả file trong thư mục gốc và các thư mục con.</li>
                                                <li>Các cơ sở dữ liệu liên kết.</li>
                                                <li>Các tài khoản FTP, cấu hình, và bản ghi DNS.</li>
                                             </ul>
                                             <p class="mt-2 mb-0 text-danger fw-bold">Hành động này <u>không thể hoàn tác</u>. Vui lòng xác nhận kỹ trước khi tiếp tục.</p>
                                          </div>
                                       </div>
                                       <div class="modal-footer border-0">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                          <i class="fa-solid fa-xmark me-1"></i> Hủy
                                          </button>
                                          <button type="button" class="btn btn-danger fw-semibold" id="btnDeleteHost">
                                          <i class="fa-solid fa-trash me-1"></i> Xác nhận xóa
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
                  document.addEventListener("DOMContentLoaded", function() {
                    const generateBtn = document.getElementById("btnGeneratePass");
                    const passwordInput = document.getElementById("newPassword");
                    function generatePassword(length = 12) {
                      const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
                      let password = "";
                      for (let i = 0; i < length; i++) {
                        password += chars.charAt(Math.floor(Math.random() * chars.length));
                      }
                      return password;
                    }
                    generateBtn.addEventListener("click", function() {
                      const newPass = generatePassword(12);
                      passwordInput.value = newPass;
                      passwordInput.focus();
                      passwordInput.select();
                      generateBtn.innerHTML = '<i class="fa-solid fa-check text-success"></i>';
                      setTimeout(() => {
                        generateBtn.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles"></i>';
                      }, 1500);
                    });
                  });
                  function removeSkeleton() {
                  $("#cpu_progress").removeClass("skel-cpu").addClass("progress-cpu");
                  $("#ram_progress").removeClass("skel-ram").addClass("progress-ram");
                  $("#disk_progress").removeClass("skel-disk").addClass("progress-disk");
                  $("#process_progress").removeClass("skel-proc").addClass("progress-proc");
                  $("#cpu_text, #ram_text, #disk_text, #process_text")
                  .removeClass("loading-text")
                  .css("color", "");
                  }
                  function loadHostInfo() {
                        $.ajax({
                        url: "/ajax/hosting/hosting.php",
                        type: "POST",
                        data: { 
                           action: "INFO_HOST",
                           id_host: <?=$id_host ?? 0;?>
                        },
                        dataType: "json",
                        success: function(res) {
                        if (res.status !== "success") return;
                        removeSkeleton();
                        let cpu = res.data.resource_usage.cpu;
                        let ram = res.data.resource_usage.ram;
                        let disk = res.data.disk_usage;
                        let process = res.data.resource_usage.process;
                        
                        $("#cpu_text").text(
                           cpu.percentage + "% (" + cpu.usage + "/" + cpu.maximum + ")"
                        );
                        $("#cpu_progress").css("width", cpu.percentage + "%");

                        $("#ram_text").text(
                           ram.percentage + "% (" + ram.usage + "MB/" + ram.maximum + "MB)"
                        );
                        $("#ram_progress").css("width", ram.percentage + "%");

                        $("#disk_text").text(
                           disk.phamtram.toFixed(2) + "% (" + disk.disk_used + "MB/" + disk.disk_limit + "MB)"
                        );
                        $("#disk_progress").css("width", disk.phamtram + "%");

                        $("#process_text").text(
                           process.percentage + "% (" + process.usage + "/" + process.maximum + ")"
                        );
                        $("#process_progress").css("width", process.percentage + "%");
                        }
                     });
                  }
                  setInterval(loadHostInfo, 5000);
                  loadHostInfo();
               </script>
            </div>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
         </div>
      </div>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
      <script>
         $(document).ready(function() {
            //đổi mật khẩu
            const $btnChangePass = $('#btnChangePass');
            const btnChangePass = async () => {
               try {
                  $btnChangePass.prop('disabled', true)
                     .html('<span class="spinner-border spinner-border-sm"></span> Đang Xử Lý...');
                  const id_host = <?=$id_host ?? 0;?>;
                  const password = $('#newPassword').val();
                  const res = await $.ajax({
                     url: '/ajax/hosting/hosting.php',
                     type: 'POST',
                     dataType: 'json',
                     data: { action: 'CHANGE_PASS', id_host: id_host, password: password },
                  });
                  if (res.status === 'success') {
                     showAlert('Thành công', res.msg, 'success');
                     setTimeout(() => {
                     window.location.reload();
                  }, 1500);
                  } else {
                     showAlert('Thất bại', res.msg, 'error');
                  }
               } catch (err) {
                  console.error(err);
                  showAlert('Thất bại', 'Lỗi kết nối máy chủ', 'error');
               } finally {
                     $btnChangePass.prop('disabled', false).html('Xác Nhận');
               }
            };
            $btnChangePass.on('click', btnChangePass);
            //login nhanh
            const $btnLoginCpanel = $('#btnLoginCpanel');
            const btnLoginCpanel = async () => {
               try {
                     $btnLoginCpanel.prop('disabled', true)
                        .html('<span class="spinner-border spinner-border-sm"></span> Đang Xử Lý...');
                     const id_host = <?=$id_host ?? 0;?>;
                     const res = await $.ajax({
                        url: '/ajax/hosting/hosting.php',
                        type: 'POST',
                        dataType: 'json',
                        data: { action: 'LOGIN_CPANEL', id_host: id_host },
                     });
                     if (res.status === 'success') {
                        window.open(res.url, '_blank');
                     } else {
                        showAlert('Thất bại', res.msg, 'error');
                     }
               } catch (err) {
                     console.error(err);
                     showAlert('Thất bại', 'Lỗi kết nối máy chủ', 'error');
               } finally {
                     $btnLoginCpanel.prop('disabled', false).html('Mở cPanel');
               }
            };
            $btnLoginCpanel.on('click', btnLoginCpanel);
            // đổi miền
            const $btnChangeDomain = $('#btnChangeDomain');
            const btnChangeDomain = async () => {
               try {
                  $btnChangeDomain.prop('disabled', true)
                     .html('<span class="spinner-border spinner-border-sm"></span> Đang Xử Lý...');
                  const id_host = <?=$id_host ?? 0;?>;
                  const domain = $('#domain').val();
                  const res = await $.ajax({
                     url: '/ajax/hosting/hosting.php',
                     type: 'POST',
                     dataType: 'json',
                     data: { action: 'CHANGE_DOMAIN', id_host: id_host, domain: domain },
                  });
                  if (res.status === 'success') {
                     showAlert('Thành công', res.msg, 'success');
                     setTimeout(() => {
                      window.location.reload();
                  }, 1500);
                  } else {
                     showAlert('Thất bại', res.msg, 'error');
                  }
               } catch (err) {
                  console.error(err);
                  showAlert('Thất bại', 'Lỗi kết nối máy chủ', 'error');
               } finally {
                     $btnChangeDomain.prop('disabled', false).html('Xác Nhận');
               }
            };
            $btnChangeDomain.on('click', btnChangeDomain);
            //gia hạn
            const $btnRenewHost = $('#btnRenewHost');
            const btnRenewHost = async () => {
               try {
                  $btnRenewHost.prop('disabled', true)
                     .html('<span class="spinner-border spinner-border-sm"></span> Đang Xử Lý...');
                  const id_host = <?=$id_host ?? 0;?>;
                  const cycle = $('#renewCycle').val();
                  const res = await $.ajax({
                     url: '/ajax/hosting/hosting.php',
                     type: 'POST',
                     dataType: 'json',
                     data: { action: 'RENEW_HOST', id_host: id_host, cycle: cycle },
                  });
                  if (res.status === 'success') {
                     showAlert('Thành công', 'Gia hạn thành công', 'success');
                     setTimeout(() => {
                        window.location.reload();
                     }, 1500);
                  } else {
                     showAlert('Thất bại', res.msg, 'error');
                  }
               } catch (err) {
                  console.error(err);
                  showAlert('Thất bại', 'Lỗi kết nối máy chủ', 'error');
               } finally {
                     $btnRenewHost.prop('disabled', false).html('Xác Nhận');
               }
            };
            $btnRenewHost.on('click', btnRenewHost);
            //thay quản trị
            const $btnChangeUser = $('#btnChangeUser');
            const btnChangeUser = async () => {
               try {
                  $btnChangeUser.prop('disabled', true)
                     .html('<span class="spinner-border spinner-border-sm"></span> Đang Xử Lý...');
                  const id_host = <?=$id_host ?? 0;?>;
                  const email = $('#email').val();
                  const res = await $.ajax({
                     url: '/ajax/hosting/hosting.php',
                     type: 'POST',
                     dataType: 'json',
                     data: { action: 'CHANGE_USER', id_host: id_host, email: email },
                  });
                  if (res.status === 'success') {
                     showAlert('Thành công', 'Chuyển quản trị viên thành công', 'success');
                  }else{
                     showAlert('Thất bại', res.msg, 'error');
                  }
               } catch (err) {
                  showAlert('Thất bại', 'Lỗi kết nối máy chủ', 'error');
               } finally {
                     $btnChangeUser.prop('disabled', false).html('Xác Nhận');
               }
            };
            $btnChangeUser.on('click', btnChangeUser);
            //xóa host
            const $btnDeleteHost = $('#btnDeleteHost');
            const btnDeleteHost = async () => {
               try {
                  $btnDeleteHost.prop('disabled', true)
                     .html('<span class="spinner-border spinner-border-sm"></span> Đang Xử Lý...');
                  const id_host = <?=$id_host ?? 0;?>;
                  const res = await $.ajax({
                     url: '/ajax/hosting/hosting.php',
                     type: 'POST',
                     dataType: 'json',
                     data: { action: 'DELETE_HOST', id_host: id_host },
                  });
                  if (res.status === 'success') {
                     showAlert('Thành công', 'Xóa hosting thành công', 'success');
                     setTimeout(() => {
                        window.location.reload();
                     }, 1500);
                  } else {
                     showAlert('Thất bại', res.msg, 'error');
                  }
               } catch (err) {
                  console.error(err);
                  showAlert('Thất bại', 'Lỗi kết nối máy chủ', 'error');
               } finally {
                     $btnDeleteHost.prop('disabled', false).html('Xác Nhận');
               }
            };
            $btnDeleteHost.on('click', btnDeleteHost);
         });
      </script>
   </body>
</html>

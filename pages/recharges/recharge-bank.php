<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <title>Nạp tiền ngân hàng | APIIT</title>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <style>
         .card-custom {
         border-radius: 10px;
         border: 1px solid #e5e7eb;
         background-color: #fff;
         }
         .section-title {
         font-weight: 600;
         font-size: 18px;
         }
         .guide-step {
         display: flex;
         align-items: start;
         margin-bottom: 15px;
         }
         .guide-number {
         width: 30px;
         height: 30px;
         border-radius: 50%;
         background-color: #0d6efd;
         color: #fff;
         display: flex;
         align-items: center;
         justify-content: center;
         font-weight: bold;
         margin-right: 10px;
         }
         .note-box {
         border: 1px solid #000;
         border-radius: 6px;
         padding: 10px;
         font-size: 14px;
         background-color: #fff;
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
                        <h4 class="page-title">Nạp Tiền Ngân Hàng</h4>
                        <div>
                           <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item">
                                 <a href="#"><i class="fa-solid fa-house me-1"></i> Trang chủ</a>
                              </li>
                              <li class="breadcrumb-item active">
                                 <i class="fa-solid fa-wallet me-1"></i> Nạp tiền
                              </li>
                           </ol>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Nội dung chính -->
               <div class="row">
                  <div class="col-lg-12">
                     <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                           <a href="/client/deposit" class="btn btn-primary me-2"><i class="fa-solid fa-building-columns me-1"></i> Ngân hàng</a>
                           <a href="/client/card" class="btn btn-outline-secondary"><i class="fa-solid fa-credit-card me-1"></i> Thẻ cào</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <!-- Phương thức thanh toán -->
                  <div class="col-lg-6">
                     <div class="card-custom p-3">
                        <h6 class="section-title mb-3">
                           <i class="fa-solid fa-wallet text-primary me-2"></i>Phương thức thanh toán
                        </h6>
                        <!-- Chọn ngân hàng -->
                        <div class="mb-3">
                           <label for="bankSelect" class="form-label">Chọn ngân hàng</label>
                           <select id="bankSelect" class="form-select">
                              <option value="">-- Chọn ngân hàng --</option>
                              <?php 
                                 // Lấy danh sách ngân hàng đang bật
                                 foreach ($ketnoi->get_list("SELECT * FROM `bank` WHERE `status` = 'on'") as $bank): ?>
                              <option 
                                 value="<?= htmlspecialchars($bank['bank']); ?>" 
                                 data-account="<?= htmlspecialchars($bank['accountNumber']); ?>" 
                                 data-name="<?= htmlspecialchars($bank['accountName']); ?>"
                                 >
                                 <?= htmlspecialchars($bank['bank']); ?> - <?= htmlspecialchars($bank['accountName']); ?>
                              </option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <!-- Khu vực hiển thị sau khi chọn -->
                        <div id="paymentInfo" class="text-center border rounded p-4 bg-light mt-3">
                           <i class="fa-solid fa-circle-info text-primary fs-5 mb-2 d-block"></i>
                           <p class="mb-0 text-muted">Vui lòng chọn phương thức thanh toán để xem chi tiết</p>
                        </div>
                     </div>
                  </div>
                  <script>
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
                     const bankSelect = document.getElementById("bankSelect");
                     const paymentInfo = document.getElementById("paymentInfo");
                     bankSelect.addEventListener("change", function() {
                     const selected = this.options[this.selectedIndex];
                     const bank = selected.value; 
                     const accountNumber = selected.dataset.account;
                     const accountName = selected.dataset.name;
                     
                     if (bank && accountNumber && accountName) {
                      paymentInfo.innerHTML = `
                        <div class="text-start">
                          <div class="mb-3">
                            <label for="amountInput" class="form-label">Nhập số tiền muốn nạp</label>
                            <input type="number" id="amountInput" class="form-control" placeholder="Nhập số tiền (VNĐ)">
                          </div>
                          <button id="createInvoiceBtn" class="btn btn-primary w-100">
                            <i class="fa-solid fa-file-invoice-dollar me-2"></i>Tạo thông tin thanh toán
                          </button>
                        </div>
                      `;
                      setTimeout(() => {
                        document.getElementById("createInvoiceBtn").addEventListener("click", function() {
                          const amount = document.getElementById("amountInput").value.trim();
                          if (!amount || amount <= 0) {
                            showAlert('Lỗi', 'Vui lòng nhập số tiền hợp lệ', 'error');
                            return;
                          }
                          if(amount < 10000) {
                           showAlert('Lỗi', 'Số tiền nạp tối thiểu là 10,000 VNĐ', 'error');
                            return;
                          }
                          const transferContent = `NAPTIEN${<?= $user['id']; ?>}`;
                          const qrUrl = `https://img.vietqr.io/image/${bank}-${accountNumber}-compact.png?amount=${amount}&addInfo=${encodeURIComponent(transferContent)}&accountName=${encodeURIComponent(accountName)}`;
                          paymentInfo.innerHTML = `
                            <div class="text-center">
                              <h6 class="mb-3 text-success">
                                <i class="fa-solid fa-circle-check me-1"></i>Thông tin thanh toán
                              </h6>
                              <img src="${qrUrl}" class="img-fluid border rounded mb-3" alt="QR Thanh toán" style="max-width:180px; height:auto;">
                              <p><strong>Ngân hàng:</strong> ${bank}</p>
                              <p><strong>Số tài khoản:</strong> ${accountNumber}</p>
                              <p><strong>Chủ tài khoản:</strong> ${accountName}</p>
                              <p><strong>Số tiền:</strong> ${parseInt(amount).toLocaleString()} VNĐ</p>
                              <p><strong>Nội dung chuyển khoản:</strong> <span class="text-danger">${transferContent}</span></p>
                              <button class="btn btn-outline-secondary w-100 mt-3" onclick="bankSelect.dispatchEvent(new Event('change'))">
                                <i class="fa-solid fa-arrow-left me-1"></i>Chọn lại
                              </button>
                            </div>
                          `;
                        });
                      }, 100);
                     } else {
                      paymentInfo.innerHTML = `
                        <i class="fa-solid fa-circle-info text-primary fs-5 mb-2 d-block"></i>
                        <p class="mb-0 text-muted">Vui lòng chọn phương thức thanh toán để xem chi tiết</p>
                      `;
                     }
                     });
                  </script>
                  <div class="col-lg-6">
                     <div class="card shadow-sm border-0 rounded-4 p-4">
                        <h5 class="fw-bold mb-4 text-primary">
                           <i class="fa-solid fa-info-circle me-2"></i> Hướng dẫn thanh toán
                        </h5>
                        <!-- Bước 1 -->
                        <div class="d-flex align-items-start mb-3">
                           <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                              style="width: 40px; height: 40px; font-weight: 600;">
                              1
                           </div>
                           <div>
                              <strong>Chọn ngân hàng</strong>
                              <p class="text-muted small mb-0">Lựa chọn ngân hàng từ danh sách hỗ trợ</p>
                           </div>
                        </div>
                        <!-- Bước 2 -->
                        <div class="d-flex align-items-start mb-3">
                           <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                              style="width: 40px; height: 40px; font-weight: 600;">
                              2
                           </div>
                           <div>
                              <strong>Nhập số tiền</strong>
                              <p class="text-muted small mb-0">Nhập đúng số tiền bạn muốn nạp</p>
                           </div>
                        </div>
                        <!-- Bước 3 -->
                        <div class="d-flex align-items-start mb-3">
                           <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-3"
                              style="width: 40px; height: 40px; font-weight: 600;">
                              3
                           </div>
                           <div>
                              <strong>Quét mã QR</strong>
                              <p class="text-muted small mb-0">Dùng ứng dụng ngân hàng để quét mã QR thanh toán</p>
                           </div>
                        </div>
                        <!-- Bước 4 -->
                        <div class="d-flex align-items-start mb-4">
                           <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center me-3"
                              style="width: 40px; height: 40px; font-weight: 600;">
                              4
                           </div>
                           <div>
                              <strong>Xác nhận giao dịch</strong>
                              <p class="text-muted small mb-0">Tiền sẽ tự động cộng sau khi ngân hàng xác nhận</p>
                           </div>
                        </div>
                        <!-- Ghi chú -->
                        <div class="alert alert-warning border-0 border-start border-4 border-warning rounded-3 shadow-sm">
                           <div class="d-flex">
                              <i class="fa-solid fa-triangle-exclamation fs-4 text-warning me-3"></i>
                              <div>
                                 <strong class="d-block mb-1">⚠️ Lưu ý quan trọng</strong>
                                 <span class="small">Chuyển khoản đúng số tiền và đúng nội dung để hệ thống tự động xử lý.</span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-12 mt-4">
                     <div class="card">
                        <div class="card-header">
                           <div class="row align-items-center">
                              <div class="col">
                                 <h4 class="card-title">Lịch sử nạp tiền</h4>
                              </div>
                              <!--end col-->
                              <!--end col-->
                           </div>
                           <!--end row-->                                  
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                           <div class="table-responsive">
                              <table class="table mb-0">
                                 <thead class="table-light">
                                    <tr>
                                       <th>ID</th>
                                       <th>Ngân Hàng</th>
                                       <th>Số Tiền</th>
                                       <th>Khuyến Mãi</th>
                                       <th>Thực Nhận</th>
                                       <th>Trạng Thái</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                       foreach($ketnoi->get_list("SELECT * FROM `history_ recharge` WHERE `username` = '$username' ORDER BY `id` DESC LIMIT 10") as $his_bank):?>
                                    <tr>
                                       <td><a href="#">#<?=$his_bank['transaction_id'];?></a></td>
                                       <td>
                                          <p class="mb-0">
                                             <span class="product-name text-body"><?=$his_bank['type'];?></span>
                                          </p>
                                       </td>
                                       <td class="text-danger"><?=money($his_bank['money']);?>đ</td>
                                       <td>0%</td>
                                       <td>
                                          <?=money($his_bank['money']);?>đ
                                       </td>
                                       <td class="text-start">
                                          <?=status($his_bank['status']);?>
                                       </td>
                                    </tr>
                                    <?php endforeach;?>   
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
         </div>
      </div>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
   </body>
</html>
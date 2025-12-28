<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <title>Nạp thẻ cào | APIIT</title>
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
                        <h4 class="page-title">Nạp Thẻ Cào</h4>
                        <div>
                           <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item">
                                 <a href="#"><i class="fa-solid fa-house me-1"></i> Trang chủ</a>
                              </li>
                              <li class="breadcrumb-item active">
                                 <i class="fa-solid fa-sim-card me-1"></i> Nạp thẻ cào
                              </li>
                           </ol>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-12">
                     <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                           <a href="/client/deposit" class="btn btn-outline-secondary"><i class="fa-solid fa-building-columns me-1"></i> Ngân hàng</a>
                           <a href="recharge-card.php" class="btn btn-primary me-2"><i class="fa-solid fa-credit-card me-1"></i> Thẻ cào</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <!-- Phương thức thanh toán -->
                  <div class="col-lg-6">
                     <div class="card-custom p-3">
                        <h6 class="section-title mb-3">
                           <i class="fa-solid fa-wallet text-primary me-2"></i>Nạp thẻ cào
                        </h6>
                        <!-- Chọn ngân hàng -->
                        <div class="mb-3">
                           <label  class="form-label">Mệnh giá</label>
                           <select id="amount" class="form-select">
                              <option value="">-- Chọn mệnh giá --</option>
                              <option value="20000" >
                                 20.000 VNĐ                          
                              </option>
                              <option value="50000" >
                                 50.000 VNĐ                          
                              </option>
                              <option value="100000" >
                                 100.000 VNĐ                          
                              </option>
                              <option value="200000" >
                                 200.000 VNĐ                          
                              </option>
                              <option value="500000" >
                                 500.000 VNĐ                          
                              </option>
                           </select>
                        </div>
                        <div class="mb-3">
                           <label  class="form-label">Nhà mạng</label>
                           <select id="telco" class="form-select">
                              <option value="">-- Chọn nhà mạng --</option>
                              <option value="viettel">Viettel</option>
                              <option value="mobifone">Mobifone</option>
                              <option value="vinaphone">Vinaphone</option>
                              <option value="vietnammobile">Vietnammobile</option>
                              <option value="zing">Zing</option>
                           </select>
                        </div>
                        <div class="mb-3">
                           <label  class="form-label">Mã thẻ</label>
                           <input type="number" id="pin" class="form-control" placeholder="Nhập mã thẻ cào">
                        </div>
                        <div class="mb-3">
                           <label  class="form-label">Số serial</label>
                           <input type="number" id="serial" class="form-control" placeholder="Nhập số serial thẻ cào">
                        </div>
                        <div id="paymentInfo" class="text-center border rounded p-4 bg-light mt-3">
                           <i class="fa-solid fa-circle-info text-primary fs-5 mb-2 d-block"></i>
                           <p class="mb-0 text-muted">
                              Thực nhận: <span id="realReceive">0đ</span>
                           </p>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary w-100" id="btnCardCharge">Nạp tiền</button>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="card shadow-sm border-0 rounded-4 p-4">
                        <h5 class="fw-bold mb-4 text-primary">
                           <i class="fa-solid fa-circle-info me-2"></i> Hướng dẫn nạp thẻ
                        </h5>
                        <div class="d-flex align-items-start mb-3">
                           <div class="guide-number bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" 
                              style="width: 40px; height: 40px; font-weight: 600;">
                              1
                           </div>
                           <div>
                              <strong>Chọn nhà mạng</strong>
                              <p class="text-muted small mb-0">Chọn nhà mạng phát hành thẻ cào</p>
                           </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                           <div class="guide-number bg-success text-white rounded-circle me-3 d-flex align-items-center justify-content-center" 
                              style="width: 40px; height: 40px; font-weight: 600;">
                              2
                           </div>
                           <div>
                              <strong>Chọn mệnh giá</strong>
                              <p class="text-muted small mb-0">Chọn mệnh giá thẻ bạn muốn nạp</p>
                           </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                           <div class="guide-number bg-warning text-white rounded-circle me-3 d-flex align-items-center justify-content-center" 
                              style="width: 40px; height: 40px; font-weight: 600;">
                              3
                           </div>
                           <div>
                              <strong>Nhập thông tin thẻ</strong>
                              <p class="text-muted small mb-0">Điền đúng số serial và mã thẻ</p>
                           </div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                           <div class="guide-number bg-danger text-white rounded-circle me-3 d-flex align-items-center justify-content-center" 
                              style="width: 40px; height: 40px; font-weight: 600;">
                              4
                           </div>
                           <div>
                              <strong>Xác nhận giao dịch</strong>
                              <p class="text-muted small mb-0">Nhấn nút nạp để hoàn tất</p>
                           </div>
                        </div>
                        <div class="alert alert-danger border-0 border-start border-4 border-danger rounded-3 shadow-sm">
                           <div class="d-flex">
                              <i class="fa-solid fa-triangle-exclamation fs-3 text-danger me-3"></i>
                              <div>
                                 <strong class="d-block mb-1">⚠️ Lưu ý quan trọng</strong>
                                 <span class="small">Vui lòng chọn đúng mệnh giá và nhà mạng để tránh mất thẻ.</span>
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
                                 <h4 class="card-title">Lịch sử nạp thẻ</h4>
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
                                       <th>Loại Thẻ</th>
                                       <th>Mệnh Giá</th>
                                       <th>Thực Nhận</th>
                                       <th>Trạng Thái</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                       $i = 1;
                                       foreach($ketnoi->get_list("SELECT * FROM `card_history` WHERE `username` = '$username' ORDER BY `id` DESC") as $card):?>
                                    <tr>
                                       <td><a href="ecommerce-order-details.html">#<?=$i++;?></a></td>
                                       <td>
                                          <p class="mb-0">
                                             <span class="product-name text-body"><?=$card['telco'];?></span>
                                          </p>
                                       </td>
                                       <td class="text-danger"><?=money($card['amount']);?>đ</td>
                                       <td class="text-danger"><?=money($card['amount']);?>đ</td>
                                       <td class="text-start">
                                          <?=($card['status']);?>
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
      <script>
         $(document).ready(function() {
            $('#amount').on('change', function () {
               const amount = parseInt($(this).val() || 0);
               const discount = 0.15; 
               const real = amount - (amount * discount); 
               $('#realReceive').text(real.toLocaleString('vi-VN') + 'đ');
            });

         });
         $(document).ready(function() {
         const $btnCardCharge = $('#btnCardCharge');
         const btnCardCharge = async () => {
             try {
                 $btnCardCharge.prop('disabled', true)
                     .html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang Xử Lý...');
                 const telco = $('#telco').val();
                 const amount = $('#amount').val();
                 const serial = $('#serial').val();
                 const pin = $('#pin').val();
                 const trans_id = $('#trans_id').val();
                 const res = await $.ajax({
                     url: '/ajax/recharge/card_charge.php',
                     type: 'POST',
                     dataType: 'json',
                     data: { action: 'CARD_CHARGE', telco, amount, serial, pin, trans_id },
                 });
                 if (res.status === 'success') {
                     showAlert('Thành công', 'Gửi thẻ thành công', 'success');
                     setTimeout(() => {
                         window.location.reload();
                     }, 1500);
                 } else {
                     showAlert('Thất bại', res.msg, 'error');
                 }
             } catch (err) {
                 console.error(err);
             } finally {
                 $btnCardCharge.prop('disabled', false).html('Nạp thẻ');
             }
         };
         $btnCardCharge.on('click', btnCardCharge);
         $(document).on('keypress', function(e) {
             if (e.which === 13) {
               btnCardCharge();
             }
         });
         });
      </script>
   </body>
</html>
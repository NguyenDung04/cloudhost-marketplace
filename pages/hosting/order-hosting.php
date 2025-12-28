<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <?php
         $id_pk = $_GET['id'];
         $pk_host = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `id` = '$id_pk' AND `status` = 'on' ");
         if(!$pk_host){
             header("Location: /404");
             exit();
         }
      ?>
      <title>Thanh toán gói hosting <?=$pk_host['name_host'];?> | APIIT</title>
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
                        <h4 class="page-title">Thanh Toán Gói Host - <?=$pk_host['name_host'];?></h4>
                        <div class="">
                           <ol class="breadcrumb mb-0">
                           <li class="breadcrumb-item">
                           <a href="/home"><i class="fa-solid fa-house me-1"></i> Trang chủ</a>
                           </li>
                           <li class="breadcrumb-item">
                           <a href="#"><i class="fa-solid fa-server me-1"></i> Hosting</a>
                           </li>
                           <li class="breadcrumb-item active">
                           <i class="fa-solid fa-credit-card me-1"></i> Thanh toán
                           </li>
                           </ol>
                        </div>
                     </div>
                     <!--end page-title-box-->
                  </div>
                  <!--end col-->
               </div>
               <!--end row-->
               <div class="row">
                  <div class="col-lg-8">
                     <div class="card">
                        <div class="card-header">
                           <div class="row align-items-center">
                              <div class="col">
                                 <h4 class="card-title">Cấu hình tùy chọn</h4>
                                 <p class="mb-0 text-muted mt-1">Tùy chỉnh dịch vụ gói hosting của bạn và tiếp tục thanh toán.</p>
                              </div>
                              <!--end col-->
                              <div class="col-auto">                      
                                 <a href="/client/package-hosting/viet-nam" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Thay Gói</a>                   
                              </div>
                              <!--end col-->
                           </div>
                           <!--end row-->                                  
                        </div>
                        <div class="card-body">
                           <h6 class="mb-3 fw-bold">Chọn khoảng thời gian</h6>
                           <div class="row g-3">
                              <!-- Option 1 -->
                              <div class="col-md-3">
                                 <input type="radio" class="btn-check" name="plan" id="plan1" checked value="1">
                                 <label class="card text-center p-3 h-100 border rounded-3 option-card" for="plan1">
                                    <h6 class="fw-bold mb-1">1 THÁNG</h6>
                                    <h5 class="fw-bold text-success mb-1">
                                       <?=money($pk_host['money']);?> đ<span class="text-muted fs-6">/Tháng</span>
                                    </h5>
                                    <span class="badge bg-light text-primary">Tiết kiệm 0 đ</span>
                                 </label>
                              </div>
                              <!-- Option 2 -->
                              <div class="col-md-3">
                                 <input type="radio" class="btn-check" name="plan" id="plan2" value="12">
                                 <label class="card text-center p-3 h-100 border rounded-3 option-card" for="plan2" >
                                    <h6 class="fw-bold mb-1">12 THÁNG (10%)</h6>
                                    <h5 class="fw-bold mb-1">
                                       <?=money($pk_host['money'] * 12 - $pk_host['money'] * 12 * 0.1);?> đ<span class="text-muted fs-6">/Tháng</span>
                                    </h5>
                                    <span class="badge bg-light text-success">Tiết kiệm <?=money($pk_host['money'] * 12 * 0.1);?> đ</span>
                                 </label>
                              </div>
                              <!-- Option 3 -->
                              <div class="col-md-3">
                                 <input type="radio" class="btn-check" name="plan" id="plan3" value="24">
                                 <label class="card text-center p-3 h-100 border rounded-3 option-card" for="plan3" >
                                    <h6 class="fw-bold mb-1">24 THÁNG (20%)</h6>
                                    <h5 class="fw-bold mb-1">
                                       <?=money($pk_host['money'] * 24 - $pk_host['money'] * 24 * 0.2);?> đ<span class="text-muted fs-6">/Tháng</span>
                                    </h5>
                                    <span class="badge bg-light text-danger">Tiết kiệm <?=money($pk_host['money'] * 24 * 0.2);?> đ</span>
                                 </label>
                              </div>
                              <!-- Option 4 -->
                              <div class="col-md-3">
                                 <input type="radio" class="btn-check" name="plan" id="plan4" value="60">
                                 <label class="card text-center p-3 h-100 border rounded-3 option-card" for="plan4">
                                    <h6 class="fw-bold mb-1">60 THÁNG (40%)</h6>
                                    <h5 class="fw-bold mb-1">
                                       <?=money($pk_host['money'] * 60 - $pk_host['money'] * 60 * 0.4);?> đ<span class="text-muted fs-6">/Tháng</span>
                                    </h5>
                                    <span class="badge bg-light text-warning">Tiết kiệm <?=money($pk_host['money'] * 60 * 0.4);?> đ</span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="domain" placeholder="Nhập tên miền vidu : domain.com" >
                     </div>
                     <div class="bg-primary-subtle p-2 border-dashed border-primary rounded mt-3">
                        <span class="text-primary fw-semibold">Lưu ý :</span><span class="text-primary fw-normal"> Kiểm tra lại toàn bộ trước khi thanh toán . Xin cảm ơn !</span>
                     </div>
                     <hr>
                     <div class="d-flex justify-content-end gap-2">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary">
                        Quay lại
                        </a>
                        <button type="button" id="btnBuyHost" class="btn btn-primary">
                        Thanh Toán
                        </button>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="card">
                        <div class="card-header">
                           <div class="row align-items-center">
                              <div class="col">
                                 <h4 class="card-title">Đơn Hàng Của Bạn</h4>
                              </div>
                           </div>
                        </div>
                        <div class="card-body">
                           <div>
                              <div class="d-flex justify-content-between">
                                 <p class="text-body fw-semibold">Gói : <span class="badge rounded text-warning bg-warning-subtle fs-12 p-1"><?=$pk_host['name_host'];?></span>  </p>
                              </div>
                              <div class="d-flex justify-content-between">
                                 <p class="text-body fw-semibold">Chu kỳ thanh toán :</p>
                                 <p class="text-body-emphasis fw-semibold" id="selecCycle">1 tháng</p>
                              </div>
                              <div class="d-flex justify-content-between">
                                 <p class="text-body fw-semibold">Giảm giá :</p>
                                 <p class="text-danger fw-semibold" id="totalDiscount">0đ</p>
                              </div>
                              <div class="d-flex justify-content-between">
                                 <p class="text-body fw-semibold">Dung Lượng :</p>
                                 <p class="text-body-emphasis fw-semibold"><?=money($pk_host['disk']);?> mb</p>
                              </div>
                           </div>
                           <hr class="hr-dashed">
                           <div class="d-flex justify-content-between">
                              <h4 class="mb-0">Tổng Tiền :</h4>
                              <h4 class="mb-0" id="totalPrice">đ</h4>
                           </div>
                        </div>
                     </div>
                     <div class="card">
                        <div class="card-header">
                           <div class="row align-items-center">
                              <div class="col">
                                 <h4 class="card-title">Mã Giảm Giá</h4>
                              </div>
                           </div>
                        </div>
                        <div class="card-body">
                           <div class="input-group mb-3">
                              <input type="text" class="form-control" placeholder="Nhập mã giảm gía" id="discount">
                              <button class="btn btn-secondary" type="button" id="button-addon2">Lấy Mã</button>
                           </div>
                           <hr class="hr-dashed">
                           <div class="d-flex justify-content-between">
                              <a type="button" class="btn btn-primary" id="applyDiscount">Áp Dụng</a>
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
         // document.querySelectorAll('input[name="plan"]').forEach(radio => {
         //    radio.addEventListener('change', function() {
         //       const selectedLabel = this.nextElementSibling.querySelector('.fw-bold').textContent;
         //       document.getElementById("selecCycle").textContent = selectedLabel;
         //       sendToServer(); 
         //    });
         // });
         function sendToServer() {
            const data = {
               action: 'LOAD_PRICE',
               id_host: <?=json_encode($id_pk);?>,
               month: document.querySelector('input[name="plan"]:checked')?.value || '1',
               discount: parseInt(document.getElementById("totalDiscount")?.textContent.replace(/\D/g, '')) || 0
            };
            fetch('/ajax/hosting/load-price.php', {
               method: 'POST',
               headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
               body: new URLSearchParams(data)
            })
            .then(res => res.json())
            .then(json => {
               if (json.status === 'success') {
                  document.getElementById("totalPrice").textContent = json.price + 'đ';
                  document.getElementById("totalRaw").textContent = json.amount_raw;
               } else {
                  document.getElementById("totalPrice").textContent = 'Báo ADMIN !!!';
               }
            })
            .catch(err => console.error('Lỗi gửi:', err));
         }
         document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('input[name="plan"]').forEach(function(radio) {
               radio.addEventListener('change', function() {
                  const selectedLabel = this.nextElementSibling.querySelector('.fw-bold').textContent;
                  document.getElementById("selecCycle").textContent = selectedLabel;
                  sendToServer();
               });
            });
            sendToServer();
         });
         $(document).ready(function() {
            const $applyDiscount = $('#applyDiscount');
            const $uiBlocker = $('#uiBlocker');
            const applyDiscount = async () => {
               try {
                  $applyDiscount.prop('disabled', true).html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang Xử Lý...');
                  $uiBlocker.fadeIn(200);
                  const discount = $('#discount').val();
                  const res = await $.ajax({
                     url: '/ajax/hosting/load-price.php',
                     type: 'POST',
                     dataType: 'json',
                     data: { action: 'DISCOUNT', discount },
                  });
                  let currentDiscount = 0;
                  if (res.status == 'success') {
                     currentDiscount = res.discount; 
                     document.getElementById("totalDiscount").textContent = res.price ; 
                     showAlert('Thành công', 'Áp dụng mã giảm giá thành công', 'success');
                     sendToServer(); 
                     if (currentDiscount > 0) {
                        $applyDiscount.prop('disabled', true)
                           .removeClass('btn-primary')
                           .addClass('btn-success')
                           .html('<i class="fa-solid fa-check me-1"></i> Đã Áp Dụng')
                           .fadeOut(500); 
                     }
                  }else{
                     showAlert('Thất bại', res.msg, 'error');
                     $applyDiscount.prop('disabled', false).html('Áp Dụng');
                  }
                  $uiBlocker.fadeOut(200);
               }catch (err) {
                  showAlert('Thất bại','Kết nối thất bại','error')
                  $uiBlocker.fadeOut(200);
               }
            }
            $applyDiscount.on('click', applyDiscount)
         });
         $(document).ready(function() {
            const $btnBuyHost = $('#btnBuyHost');
            const $uiBlocker = $('#uiBlocker');
            const btnBuyHost = async () => {
               try {
                  const confirmBuy = await Swal.fire({
                     title: 'Xác nhận mua Hosting?',
                     text: 'Bạn có chắc chắn muốn thanh toán và kích hoạt Hosting này không?',
                     icon: 'question',
                     showCancelButton: true,
                     confirmButtonText: 'Đồng ý mua',
                     cancelButtonText: 'Hủy'
                  });
                  if (!confirmBuy.isConfirmed) return; 
                  $uiBlocker.fadeIn(200);
                  $btnBuyHost.prop('disabled', true).html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang Xử Lý...');
                  const res = await $.ajax({
                     url: '/ajax/hosting/hosting.php',
                     type: 'POST',
                     dataType: 'json',
                     data: { action: 'BUY_HOST', id_host: <?=json_encode($id_pk);?>, month: document.querySelector('input[name="plan"]:checked')?.value || '1', discount: parseInt(document.getElementById("totalDiscount").textContent.replace(/\D/g, '')) || 0, domain: $('#domain').val() },
                  });
                  if(res.status == 'success'){
                     showAlert('Thành công','Thanh toán thành công','success')
                     setTimeout(() => {
                        window.location.href = '/client/history/hosting';
                     }, 1500);
                  }else{
                     showAlert('Thất bại', res.msg, 'error');
                     $btnBuyHost.prop('disabled', false).html('Thanh Toán');
                  }
                  $uiBlocker.fadeOut(200);
               }catch(err){
                  showAlert('Thất bại','Kết nối thất bại','error')
                  $uiBlocker.fadeOut(200);
                  $btnBuyHost.prop('disabled', false).html('Thanh Toán');
               }
            }
            $btnBuyHost.on('click', btnBuyHost);
         });
</script>
   </body>
</html>
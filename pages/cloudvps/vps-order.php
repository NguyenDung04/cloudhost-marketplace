<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <?php 
         $id = $_GET['id'];
         $vps = $ketnoi->get_row("SELECT * FROM `package_cloudvps` WHERE `id` = '$id' AND `status` = 'hoatdong' ");
         if (!$vps) {
            header("Location: /404");
            exit();
         }
         $price = json_decode($vps['price'], true);
         ?>
      <title>Trang Chủ | APIIT</title>
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
                        <h4 class="page-title">Thanh Toán - <?=$vps['name'];?></h4>
                        <div class="">
                           <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item">
                                 <a href="/home"><i class="fa-solid fa-house me-1"></i> Trang Chủ</a>
                              </li>
                              <li class="breadcrumb-item">
                                 <a href="/client/vps-platium"><i class="fa-solid fa-database me-1"></i> Cloud Server</a>
                              </li>
                              <li class="breadcrumb-item active">
                                 <i class="fa-solid fa-cloud me-1"></i> Thanh Toán
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
                                 <p class="mb-0 text-muted mt-1">Tùy chỉnh dịch vụ Cloud VPS của bạn và tiếp tục thanh toán.</p>
                              </div>
                              <!--end col-->
                              <div class="col-auto">                      
                                 <button class="btn btn-primary"><i class="fas fa-plus me-1"></i>Thay Gói</button>                   
                              </div>
                              <!--end col-->
                           </div>
                           <!--end row-->                                  
                        </div>
                        <div class="card-body">
                           <h6 class="mb-3 fw-bold">Chọn khoảng thời gian</h6>
                           <div class="row g-3">
                              <?php foreach ($price as $cycle => $info):
                                 $months_map = [
                                    'monthly'      => 1,
                                    'twomonthly'   => 2,
                                    'quarterly'    => 3,
                                    'semi_annually'=> 6,
                                    'annually'     => 12,
                                    'biennially'   => 24,
                                    'triennially'  => 36
                                 ];
                                 $months = $months_map[$cycle] ?? 1;
                                 $saved = ($price['monthly']['amount'] * $months) - $info['amount'];
                                 $saved = $saved > 0 ? $saved : 0; ?>
                              <div class="col-md-3">
                                 <input type="radio" class="btn-check" name="plan" id="<?=$cycle?>" value="<?=$cycle?>" <?=$cycle === 'monthly' ? 'checked' : ''?> >
                                 <label class="card text-center p-3 h-100 border rounded-3 option-card" for="<?=$cycle?>" >
                                    <h6 class="fw-bold mb-1"><?=$info['billing_cycle']?></h6>
                                    <h5 class="fw-bold text-success mb-1">
                                       <?=money($info['amount'])?> đ<span class="text-muted fs-6">/<?=$info['billing_cycle']?></span>
                                    </h5>
                                    <span class="badge bg-light text-primary">
                                    Tiết kiệm <?= money($saved) ?> đ 
                                    </span>
                                 </label>
                              </div>
                              <?php endforeach; ?>
                           </div>
                        </div>
                     </div>
                     <div class="card">
                        <div class="card-header">
                           <div class="row align-items-center">
                              <div class="col">
                                 <h4 class="card-title">Cấu hình tài nguyên</h4>
                              </div>
                           </div>
                        </div>
                        <div class="card-body text-center">
                           <div class="row">
                              <!-- CPU -->
                              <div class="col-md-4 mb-3">
                                 <h5><span id="cpuVal">0</span> vCore</h5>
                                 <p class="text-muted">CPU (Core)</p>
                                 <div class="d-flex justify-content-center align-items-center gap-3">
                                    <button class="btn btn-outline-secondary btn-sm" onclick="changeValue('cpu', -1)">-</button>
                                    <div class="circle-value" id="cpuCircle">0</div>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="changeValue('cpu', 1)">+</button>
                                 </div>
                              </div>
                              <!-- RAM -->
                              <div class="col-md-4 mb-3">
                                 <h5><span id="ramVal">0</span> GB</h5>
                                 <p class="text-muted">RAM (GB)</p>
                                 <div class="d-flex justify-content-center align-items-center gap-3">
                                    <button class="btn btn-outline-secondary btn-sm" onclick="changeValue('ram', -1)">-</button>
                                    <div class="circle-value" id="ramCircle">0</div>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="changeValue('ram', 1)">+</button>
                                 </div>
                              </div>
                              <!-- DISK -->
                              <div class="col-md-4 mb-3">
                                 <h5><span id="diskVal">0</span> GB</h5>
                                 <p class="text-muted">DISK (+10 GB/bước)</p>
                                 <div class="d-flex justify-content-center align-items-center gap-3">
                                    <button class="btn btn-outline-secondary btn-sm" onclick="changeValue('disk', -10)">-</button>
                                    <div class="circle-value" id="diskCircle">0</div>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="changeValue('disk', 10)">+</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!--card-body-->
                     </div>
                     <div class="card">
                        <div class="card-header">
                           <div class="row align-items-center">
                              <div class="col">
                                 <h4 class="card-title">Hệ điều hành</h4>
                              </div>
                           </div>
                        </div>
                        <div class="card-body text-center">
                           <div class="row g-3">
                              <?php foreach($ketnoi->get_list("SELECT * FROM `img_os`") as $index => $os): ?>
                              <div class="col-6 col-md-3">
                                 <input type="radio" class="btn-check" name="os" id="os<?=$os['id'];?>" 
                                    value="<?=$os['os_name'];?>" <?= $index === 0 ? 'checked' : '' ?>>
                                 <label for="os<?=$os['id'];?>" class="os-card border rounded-3 p-3 d-block h-100">
                                    <img src="<?=$os['image_url'];?>" alt="<?=$os['os_name'];?>" height="40" class="mb-2">
                                    <div class="fw-bold small"><?=$os['os_name'];?></div>
                                    <input type="text" value="<?=$os['id'];?>" hidden  id="id_os">
                                 </label>
                              </div>
                              <?php endforeach; ?>
                           </div>
                        </div>
                     </div>
                     <div class="bg-primary-subtle p-2 border-dashed border-primary rounded mt-3">
                        <span class="text-primary fw-semibold">Lưu ý :</span><span class="text-primary fw-normal"> Kiểm tra lại toàn bộ trước khi thanh toán . Xin cảm ơn !</span>
                     </div>
                     <hr>
                     <div class="d-flex justify-content-end gap-2">
                        <a href="#" onclick="if (document.referrer) { history.back(); } else { window.location.href='/client/'; }" class="btn btn-outline-secondary">
                        Quay lại
                        </a>
                        <button type="button" id="btnBuyVps" class="btn btn-primary">
                        Thanh Toán
                        </button>
                     </div>
                     <!--end card-->
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
                                 <p class="text-body fw-semibold">Gói : <span class="badge rounded text-warning bg-warning-subtle fs-12 p-1"><?=$vps['name'];?></span>  </p>
                              </div>
                              <div class="d-flex justify-content-between">
                                 <p class="text-body fw-semibold">Chu kỳ thanh toán :</p>
                                 <p class="text-body-emphasis fw-semibold" id="selectedCycle">1 tháng</p>
                              </div>
                              <div class="d-flex justify-content-between">
                                 <p class="text-body fw-semibold">Giảm giá :</p>
                                 <p class="text-danger fw-semibold" id="totalDiscount">0đ</p>
                              </div>
                              <div class="d-flex justify-content-between">
                                 <p class="text-body fw-semibold">CPU (Mua Thêm) :</p>
                                 <p class="text-body-emphasis fw-semibold" id="totalCPU">0</p>
                              </div>
                              <div class="d-flex justify-content-between">
                                 <p class="text-body fw-semibold">RAM (Mua Thêm) :</p>
                                 <p class="text-body-emphasis fw-semibold" id="totalRAM">0</p>
                              </div>
                              <div class="d-flex justify-content-between">
                                 <p class="text-body fw-semibold">DISK (Mua Thêm) :</p>
                                 <p class="text-body-emphasis fw-semibold" id="totalDISK">0</p>
                              </div>
                              <div class="d-flex justify-content-between">
                                 <p class="text-body fw-semibold mb-0">OS :</p>
                                 <p class="text-body-emphasis fw-semibold mb-0" id="selectedOS">Windows Server 2016
                                 </p>
                              </div>
                           </div>
                           <hr class="hr-dashed">
                           <div class="d-flex justify-content-between">
                              <h4 class="mb-0">Tổng Tiền :</h4>
                              <h4 class="mb-0"><span id="totalPrice">0</span> đ</h4>
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
                              <input type="text" class="form-control" id="discount" placeholder="Nhập mã giảm gía" >
                              <button class="btn btn-secondary" type="button" id="button-addon2">Lấy Mã</button>
                           </div>
                           <hr class="hr-dashed">
                           <div class="d-flex justify-content-between">
                              <button type="button" id="applyDiscount" class="btn btn-primary">Áp Dụng</button>
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
         let cpu = 0, ram = 0, disk = 0;
         function sendToServer() {
            const data = {
               action: 'LOAD_PRICE',
               vpsid: <?=json_encode($vps['id']);?>,
               billingcycle: document.querySelector('input[name="plan"]:checked')?.value || 'monthly',
               cpu: cpu,
               ram: ram,
               disk: disk,
               os: document.querySelector('input[name="os"]:checked')?.value || '',
               discount: parseInt(document.getElementById("totalDiscount").textContent.replace(/\D/g, '')) || 0
            };
            fetch('/ajax/cloud/load-price.php', {
               method: 'POST',
               headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
               body: new URLSearchParams(data)
            })
            .then(res => res.json())
            .then(json => {
               if(json.status == 'success'){
                  document.getElementById("totalPrice").textContent = json.price;
               }else{
                  document.getElementById("totalPrice").textContent = 'Báo ADMIN !!!';
               }
            })
            .catch(err => console.error('Lỗi gửi:', err));
         }
         function changeValue(type, step) {
            if (type === 'cpu') {
               cpu = Math.max(0, Math.min(10, cpu + step));
               document.getElementById("cpuVal").textContent = cpu;
               const total = cpu * 35000;
               document.getElementById("totalCPU").textContent = total.toLocaleString('vi-VN', {style: 'currency', currency: 'VND'});
               document.getElementById("cpuCircle").textContent = cpu;
            } 
            else if (type === 'ram') {
               ram = Math.max(0, Math.min(10, ram + step));
               document.getElementById("ramVal").textContent = ram;
               const total = ram * 20000;
               document.getElementById("totalRAM").textContent = total.toLocaleString('vi-VN', {style: 'currency', currency: 'VND'});
               document.getElementById("ramCircle").textContent = ram;
            } 
            else if (type === 'disk') {
               disk = Math.max(0, Math.min(100, disk + step));
               document.getElementById("diskVal").textContent = disk;
               const total = disk * 1200;
               document.getElementById("totalDISK").textContent = total.toLocaleString('vi-VN', {style: 'currency', currency: 'VND'});
               document.getElementById("diskCircle").textContent = disk;
            }
            sendToServer(); 
         }
         document.querySelectorAll('input[name="os"]').forEach(radio => {
            radio.addEventListener('change', function() {
               const selectedLabel = this.nextElementSibling.querySelector('.fw-bold').textContent;
               document.getElementById("selectedOS").textContent = selectedLabel;
               sendToServer(); 
            });
         });
         document.querySelectorAll('input[name="plan"]').forEach(plan => {
            plan.addEventListener('change', function() {
               const selectedCycle = this.nextElementSibling.querySelector('.fw-bold').textContent;
               document.getElementById("selectedCycle").textContent = selectedCycle;
               sendToServer(); 
            });
         });
         window.addEventListener('DOMContentLoaded', function() {
            const checkedOS = document.querySelector('input[name="os"]:checked');
            if (checkedOS) {
               const selectedLabel = checkedOS.nextElementSibling.querySelector('.fw-bold').textContent;
               document.getElementById("selectedOS").textContent = selectedLabel;
            }
            sendToServer(); 
         });
         $(document).ready(function() {
            const $applyDiscount = $('#applyDiscount');
            const $uiBlocker = $('#uiBlocker');
            const applyDiscount = async () => {
               try {
                  $uiBlocker.fadeIn(200);
                  $applyDiscount.prop('disabled', true).html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang Xử Lý...');
                  const discount = $('#discount').val();
                  const res = await $.ajax({
                     url: '/ajax/cloud/load-price.php',
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
                           .html('<i class="fa-solid fa-check me-1"></i> Đã Áp Dụng');
                     }
                  }else{
                     showAlert('Thất bại', res.msg, 'error');
                     $applyDiscount.prop('disabled', false).html('Áp Dụng');
                  }
                  $uiBlocker.fadeOut(200);
               } catch (err) {
                  showAlert('Thất bại', 'Lỗi kết nối máy chủ', 'error');
                  $applyDiscount.prop('disabled', false).html('Áp Dụng');
                  $uiBlocker.fadeOut(200);
               } 
            };
            $applyDiscount.on('click', applyDiscount);
         });
         $(document).ready(function() {
            const $btnBuyVps = $('#btnBuyVps');
            const $uiBlocker = $('#uiBlocker');
            const btnBuyVps = async () => {
               const confirmBuy = await Swal.fire({
                  title: 'Xác nhận mua VPS?',
                  text: 'Bạn có chắc chắn muốn thanh toán và kích hoạt VPS này không?',
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonText: 'Đồng ý mua',
                  cancelButtonText: 'Hủy'
               });
               if (!confirmBuy.isConfirmed) return; 
               try{
                  $uiBlocker.fadeIn(200);
                  $btnBuyVps.prop('disabled', true).html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang Xử Lý...');
                  const res = await $.ajax({
                     url: '/ajax/cloud/cloud-vps.php',
                     type: 'POST',
                     dataType: 'json',
                     data: { 
                        action: 'BUY_VPS', 
                        vpsid: <?=json_encode($vps['product_id']);?>, 
                        billingcycle: document.querySelector('input[name="plan"]:checked')?.value || 'monthly', 
                        cpu: cpu, 
                        ram: ram, 
                        disk: disk, 
                        os: document.getElementById("id_os").value, 
                        discount: parseInt(document.getElementById("totalDiscount").textContent.replace(/\D/g, '')) || 0 },
                  });
                  if(res.status == 'success'){
                     showAlert('Thành công', 'Thanh toán thành công', 'success');
                     setTimeout(() => {
                        window.location.href = '/client/vps-platium';
                     }, 1500);
                  }else{
                     showAlert('Thất bại', res.msg, 'error');
                     $btnBuyVps.prop('disabled', false).html('Thanh Toán');
                  }
               }catch(err){
                  showAlert('Thất bại', 'Lỗi kết nối máy chủ', 'error');
               }finally{
                  $uiBlocker.fadeOut(200);
                  $btnBuyVps.prop('disabled', false).html('Thanh Toán');
               }
            }
            $btnBuyVps.on('click', btnBuyVps);
         });
      </script>
      
   </body>
</html>
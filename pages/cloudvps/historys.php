<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <title>Lịch sử mua vps | APIIT</title>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';
      // require $_SERVER['DOCUMENT_ROOT'].'/core/cloud-vps.php';
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
                        <h4 class="page-title">Dịch vụ VPS đang sử dụng
                        </h4>
                        <div class="">
                        <ol class="breadcrumb mb-0">
                           <li class="breadcrumb-item">
                              <a href="/home"><i class="fa-solid fa-house me-1"></i> Trang chủ</a>
                           </li>
                           <li class="breadcrumb-item">
                              <a href="/client/vps-platium"><i class="fa-solid fa-server me-1"></i> VPS</a>
                           </li>
                           <li class="breadcrumb-item active">
                              <i class="fa-solid fa-cloud-arrow-up me-1"></i> Dịch vụ VPS đang sử dụng
                           </li>
                           </ol>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <h5 class="card-title mb-0">Danh sách đơn hàng VPS</h5>
                  </div>
                  <div class="card-body">
                     <div class="row mb-3">
                        <div class="col-md-6 d-flex align-items-center">
                           <label class="me-2">
                              <select class="form-select form-select-sm w-auto" name="length" onchange="this.form.submit()">
                                 <option value="10" selected>10</option>
                                 <option value="25">25</option>
                                 <option value="50">50</option>
                                 <option value="100">100</option>
                              </select>
                           </label>
                           <span> entries per page</span>
                        </div>
                        <div class="col-md-6 text-end">
                           <input type="text" name="search" class="form-control form-control-sm d-inline-block w-auto" placeholder="Search...">
                        </div>
                     </div>
                     <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                           <thead class="table-light">
                              <tr>
                                 <th>IP</th>
                                 <th>Mật Khẩu</th>
                                 <th >Gói </th>
                                 <th>Ngày tạo</th>
                                 <th>Ngày kết thúc</th>
                                 <th>Thời gian thuê</th>
                                 <th>Giá</th>
                                 <th>Trạng thái</th>
                                 <th>Hành Động</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php 
                                 foreach ($list_vps = $ketnoi->get_list("SELECT * FROM `purchased_cloudvps` WHERE `username` = '$username' AND `status` != 'delete_vps' AND `status` != 'cancel'") as $vps):?>
                              <?php
                                 $vps_ids = array_column($list_vps, 'id_vps');
                                 $vps_info = json_decode($vps['info'], true);
                                 $id_product = (int)$vps['id_produc'];
                                 $check_product = $ketnoi->get_row("SELECT * FROM `package_cloudvps` WHERE `product_id` = $id_product");
                                 $data = json_decode($vps['data'],true) ;
                                 ?>
                              <tr>
                                 <td class="text-danger"><?=$vps_info[0]['ip'];?></td>
                                 <td>
                                    <div>
                                       <strong>Tài khoản:</strong> <?=$vps_info[0]['username'];?> <br>
                                       <strong>Mật khẩu:</strong>
                                       <?php $vpsId = $vps_info[0]['vps-id'] ?? $vps['id_vps']; ?>
                                       <span id="vps-pass-<?=$vpsId;?>" class="fw-semibold" style="letter-spacing: 2px;">••••••••</span>
                                       <button type="button" class="btn btn-sm btn-light border ms-1" id="toggle-pass-<?=$vpsId;?>" title="Hiện/Ẩn mật khẩu">
                                       <i class="fa-solid fa-eye"></i>
                                       </button>
                                       <button type="button" class="btn btn-sm btn-outline-secondary ms-1" id="copy-pass-<?=$vpsId;?>" title="Sao chép mật khẩu">
                                       <i class="fa-solid fa-copy"></i>
                                       </button>
                                    </div>
                                    <script>
                                       document.addEventListener("DOMContentLoaded", function() {
                                         const passText = "<?= $data['password']; ?>";
                                         const passSpan = document.getElementById("vps-pass-<?=$vpsId;?>");
                                         const toggleBtn = document.getElementById("toggle-pass-<?=$vpsId;?>");
                                         const copyBtn = document.getElementById("copy-pass-<?=$vpsId;?>");
                                         let isShown = false;
                                         if (toggleBtn && passSpan && copyBtn) {
                                           toggleBtn.addEventListener("click", function() {
                                             isShown = !isShown;
                                             if (isShown) {
                                               passSpan.textContent = passText;
                                               toggleBtn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
                                             } else {
                                               passSpan.textContent = "••••••••";
                                               toggleBtn.innerHTML = '<i class="fa-solid fa-eye"></i>';
                                             }
                                           });
                                           copyBtn.addEventListener("click", function() {
                                             navigator.clipboard.writeText(passText).then(() => {
                                               copyBtn.innerHTML = '<i class="fa-solid fa-check text-success"></i>';
                                               setTimeout(() => {
                                                 copyBtn.innerHTML = '<i class="fa-solid fa-copy"></i>';
                                               }, 1500);
                                             });
                                           });
                                         }
                                       });
                                    </script>
                                 </td>
                                 <td><strong class="text-primary"><?=$check_product['name'];?></strong></td>
                                 <td><?=fmDate($vps['created_at']);?></td>
                                 <td><?=fmDate($vps['end_date']);?> </td>
                                 <td><?=check_Month($vps['billingcycle']);?></td>
                                 <td><?=money($vps['money']);?>đ</td>
                                 <td id="status-<?=$vps['id_vps'];?>"><?=status_vps($vps['status']);?></td>
                                 <td>
                                    <a href="/client/vps-manage/<?=$vps['id_vps'];?>">Chi tiết</a>
                                 </td>
                              </tr>
                              <?php endforeach ?>
                           </tbody>
                        </table>
                     </div>
                     <div class="row mt-2">
                        <div class="col-md-6">
                           <small>Showing 1 to 10 of 11 entries</small>
                        </div>
                        <div class="col-md-6">
                           <ul class="pagination pagination-sm justify-content-end mb-0">
                              <li class="page-item disabled">
                                 <a class="page-link" href="#">Previous</a>
                              </li>
                              <li class="page-item active">
                                 <a class="page-link" href="#">1</a>
                              </li>
                              <li class="page-item">
                                 <a class="page-link" href="#">2</a>
                              </li>
                              <li class="page-item">
                                 <a class="page-link" href="#">Next</a>
                              </li>
                           </ul>
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
         document.addEventListener("DOMContentLoaded", () => {
         fetch('/ajax/cloud/sync_vps.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ ids: <?=json_encode($vps_ids)?> })
         })
         .then(res => res.json())
         .then(json => {
            if (json.success && json.data) {
               json.data.forEach(vps => {
               const ipEl = document.getElementById('ip-' + vps['vps-id']);
               if (ipEl && vps.ip) ipEl.textContent = vps.ip;
               const userEl = document.getElementById('user-' + vps['vps-id']);
               if (userEl && vps.username) userEl.textContent = vps.username;
               const statusEl = document.getElementById('status-' + vps['vps-id']);
               if (statusEl && vps['html-status']) statusEl.innerHTML = vps['html-status'];
               });
            }
         })
         .catch(err => console.error('Sync VPS error:', err));
         });
      </script>
   </body>
</html>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <title>Lịch Sử Mua Hosting | APIIT</title>
      
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
                        <h4 class="page-title">Lịch sử mua hosting </h4>
                        <div class="">
                           <ol class="breadcrumb mb-0">
                           <li class="breadcrumb-item">
                           <a href="/home"><i class="fa-solid fa-house me-1"></i> Trang chủ</a>
                           </li>
                           <li class="breadcrumb-item">
                           <a href="#"><i class="fa-solid fa-server me-1"></i> Hosting</a>
                           </li>
                           <li class="breadcrumb-item active">
                           <i class="fa-solid fa-receipt me-1"></i> Lịch sử mua hosting
                           </li>
                           </ol>
                        </div>
                     </div>
                     <!--end page-title-box-->
                  </div>
                  <!--end col-->
               </div>
               <!--end row-->                   
               <div class="card">
                  <div class="card-header">
                     <h5 class="card-title mb-0">Danh sách đơn hàng hosting</h5>
                  </div>
                  <div class="card-body">
                     <div class="row mb-3">
                        <div class="col-md-6 d-flex align-items-center">
                           <label class="me-2">
                              <select class="form-select form-select-sm w-auto" name="length" onchange="this.form.submit()">
                                 <option value="10" selected="">10</option>
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
                                 <th>Gói </th>
                                 <th>Ngày tạo</th>
                                 <th>Ngày kết thúc</th>
                                 <th>Thời gian còn</th>
                                 <th>Giá</th>
                                 <th>Trạng thái</th>
                                 <th>Ghi Chú</th>
                                 <th>Hành Động</th>
                              </tr>
                           </thead>
                           <tbody>
                             <?php foreach($ketnoi->get_list("SELECT * FROM `history_buy_hosting` WHERE `username` = '$username'") as $hosting):?>
                              <?php
                                $sv_host = $hosting['sv_host'];
                                $server_host = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `id` = '$sv_host' ");
                                $pk_host = $hosting['pk_host'];
                                $package_host = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `code_host` = '$pk_host' ");
                              ?>
                                <tr>
                                 <td class="text-danger"><?=$server_host['ip_whm'];?></td>
                                 <td>
                                    <div>
                                        <strong>Tài khoản:</strong> <?= decodecryptData($hosting['account']); ?><br>
                                        <strong>Mật khẩu:</strong>
                                        <span id="vps-pass-<?=$hosting['id'];?>" class="fw-semibold" style="letter-spacing: 2px;">••••••••</span>
                                        <button type="button" class="btn btn-sm btn-light border ms-1" id="toggle-pass-<?=$hosting['id'];?>" title="Hiện/Ẩn mật khẩu">
                                        <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary ms-1" id="copy-pass-<?=$hosting['id'];?>" title="Sao chép mật khẩu">
                                        <i class="fa-solid fa-copy"></i>
                                        </button>
                                    </div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                        const passText = <?= json_encode(decodecryptData($hosting['password'])); ?>; 
                                        const passSpan = document.getElementById("vps-pass-<?=$hosting['id'];?>");
                                        const toggleBtn = document.getElementById("toggle-pass-<?=$hosting['id'];?>");
                                        const copyBtn = document.getElementById("copy-pass-<?=$hosting['id'];?>");
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
                                 <td><strong class="text-primary"><?=$package_host['name_host'];?></strong></td>
                                 <td><?=fmDate($hosting['creatAt']);?></td>
                                 <td><?=fmDate($hosting['endAt']);?></td>
                                 <td><?=timeDifference($hosting['creatAt'], $hosting['endAt']);?> ngày</td>
                                 <td><?=money($hosting['total_money'] ?? 0);?>đ</td>
                                 <td id="status-4000">
                                   <?=status_vps($hosting['status']);?>
                                 </td>
                                 <td>
                                   <?=($hosting['note']);?>
                                 </td>
                                 <td>
                                    <a href="/client/hosting-manage/<?=$hosting['id'];?>">Chi tiết</a>
                                 </td>
                              </tr>
                              <?php endforeach;?>
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
   </body>
</html>
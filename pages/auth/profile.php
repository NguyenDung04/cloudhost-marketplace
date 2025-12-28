<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <title>Thông tin cá nhân | APIIT</title>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <?php
         $total_recharge = $ketnoi->num_rows("SELECT * FROM `history_ recharge` WHERE `username` = '$username'");
         ?>
      <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->
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
                        <h4 class="page-title">Thông tin cá nhân</h4>
                        <div class="">
                           <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item">
                                 <a href="/home"><i class="fa-solid fa-house me-1"></i> Trang Chủ</a>
                              </li>
                              <li class="breadcrumb-item active">
                              <i class="fa-solid fa-id-card me-1"></i> Thông tin cá nhân
                              </li>
                           </ol>
                        </div>
                     </div>
                  </div>
               </div>
               <!--end row-->
               <div class="row">
                  <div class="col-md-4">
                     <div class="card">
                        <div class="card-header">
                           <div class="row align-items-center">
                              <div class="col">
                                 <h4 class="card-title">Thông Tin Cá Nhân</h4>
                              </div>
                              <div class="col-auto">                      
                                 <a href="#" class="float-end text-muted d-inline-flex text-decoration-underline"><i class="iconoir-edit-pencil fs-18 me-1"></i>Edit</a>                      
                              </div>
                           </div>
                        </div>
                        <div class="card-body">
                           <ul class="list-unstyled mb-0">
                              <li>
                                 <i class="fa-solid fa-user me-2 text-secondary fs-22 align-middle"></i>
                                 <b>Họ Và Tên</b> : Nguyễn Chính
                              </li>
                              <li class="mt-2">
                                 <i class="fa-solid fa-user me-2 text-secondary fs-22 align-middle"></i>
                                 <b>Tên Tài Khoản</b> : <?=strtoupper($username);?>
                              </li>
                              <li class="mt-2">
                                 <i class="fa-solid fa-briefcase me-2 text-secondary fs-22 align-middle"></i>
                                 <b>Email</b> : <?=$user['email'];?> 
                                 <?php if($user['veri_email'] == 'on'): ?> 
                                 <img src="/core/upload/images/loading.gif" alt="very email" height="20">
                                 <?php endif; ?>
                              </li>
                              <li class="mt-2">
                                 <i class="fa-solid fa-phone me-2 text-secondary fs-22 align-middle"></i>
                                 <b>Số điện thoại</b> : <?=$user['phone'];?>
                              </li>
                              <li class="mt-2">
                                 <i class="fa-solid fa-location-dot me-2 text-secondary fs-22 align-middle"></i>
                                 <b>Địa chỉ</b> : <?=$user['ip_adr'];?> | <?=$user['address'];?>
                              </li>
                           </ul>
                           <div class="row justify-content-center mt-4">
                              <div class="col-auto text-end border-end">
                                 <span class="thumb-md justify-content-center d-flex align-items-center bg-blue text-white rounded-circle ms-auto mb-1">
                                 <i class="fab fa-facebook-f"></i>
                                 </span>
                                 <p class="mb-0 fw-semibold">Facebook</p>
                              </div>
                              <div class="col-auto">
                                 <span class="thumb-md justify-content-center d-flex align-items-center bg-black text-white rounded-circle mb-1">
                                 <i class="fab fa-x-twitter"></i>
                                 </span>
                                 <p class="mb-0 fw-semibold">Tele</p>
                              </div>
                              <!--end col-->
                           </div>
                           <!--end row-->       
                        </div>
                        <!--end card-body--> 
                     </div>
                     <!--end card-->                            
                  </div>
                  <!--end col--> 
                  <div class="col-lg-8">
                     <?php if($user['veri_email'] == 'off'): ?>
                     <div class="bg-danger-subtle p-2 border-dashed border-danger rounded mb-3">
                        <span class="text-danger fw-semibold">Email chưa được xác thực</span>
                     </div>
                     <?php endif; ?>
                     <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                           <div class="card">
                              <div class="card-body">
                                 <div class="d-flex align-items-center">
                                    <i class="iconoir-dollar-circle fs-24 align-self-center text-info me-2"></i>
                                    <div class="flex-grow-1 text-truncate">
                                       <p class="text-dark mb-0 fw-semibold fs-13">Số Dư</p>
                                       <h3 class="mt-1 mb-0 fs-18 fw-bold"><?=money($user['money']);?><span class="fs-11 text-muted fw-normal"> đ</span> </h3>
                                    </div>
                                    <!--end media body-->
                                 </div>
                              </div>
                              <!--end card-body-->
                           </div>
                           <!--end card-body-->                     
                        </div>
                        <!--end col-->
                        <div class="col-md-6 col-lg-3">
                           <div class="card">
                              <div class="card-body">
                                 <div class="d-flex align-items-center">
                                    <i class="iconoir-cart fs-24 align-self-center text-blue me-2"></i>
                                    <div class="flex-grow-1 text-truncate">
                                       <p class="text-dark mb-0 fw-semibold fs-13">Đã Chi</p>
                                       <h3 class="mt-1 mb-0 fs-18 fw-bold"><?=money($user['total_money'] - $user['money']);?> <span class="fs-11 text-muted fw-normal"> đ</span> </h3>
                                    </div>
                                 </div>
                              </div>
                           </div>                
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="card">
                              <div class="card-body">
                                 <div class="d-flex align-items-center">
                                    <i class="iconoir-thumbs-up fs-24 align-self-center text-primary me-2"></i>
                                    <div class="flex-grow-1 text-truncate">
                                       <p class="text-dark mb-0 fw-semibold fs-13">Tổng Nạp</p>
                                       <h3 class="mt-1 mb-0 fs-18 fw-bold"><?=money($user['total_money']);?> <span class="fs-11 text-muted fw-normal"> đ</span> </h3>
                                    </div>
                                    <!--end media body-->
                                 </div>
                              </div>
                              <!--end card-body-->
                           </div>
                           <!--end card-->                     
                        </div>
                        <!--end col-->  
                        <div class="col-md-6 col-lg-3">
                           <div class="card">
                              <div class="card-body">
                                 <div class="d-flex align-items-center">
                                    <i class="iconoir-xmark-circle fs-24 align-self-center text-danger me-2"></i>
                                    <div class="flex-grow-1 text-truncate">
                                       <p class="text-dark mb-0 fw-semibold fs-13">Đơn Nạp</p>
                                       <h3 class="mt-1 mb-0 fs-18 fw-bold"><?=money($total_recharge);?> <span class="fs-11 text-muted fw-normal"> nạp</span> </h3>
                                    </div>
                                 </div>
                              </div>
                              <!--end card-body-->
                           </div>
                           <!--end card-body-->                     
                        </div>
                        <!--end col-->                              
                     </div>
                     <!--end row-->
                     <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                           <a class="nav-link fw-medium active" data-bs-toggle="tab" href="#post" role="tab" aria-selected="false" tabindex="-1">Lịch sử đăng nhập</a>
                        </li>
                        <li class="nav-item" role="presentation">
                           <a class="nav-link fw-medium" data-bs-toggle="tab" href="#gallery" role="tab" aria-selected="false" tabindex="-1">Đổi mật khẩu</a>
                        </li>
                        <li class="nav-item" role="presentation">
                           <a class="nav-link fw-medium " data-bs-toggle="tab" href="#settings" role="tab" aria-selected="true">Bảo mật</a>
                        </li>
                        <li class="nav-item" role="presentation">
                           <a class="nav-link fw-medium " data-bs-toggle="tab" href="#api_token" role="tab" aria-selected="true">API Token</a>
                        </li>
                        <li class="nav-item" role="presentation">
                           <a class="nav-link fw-medium " data-bs-toggle="tab" href="#veri_email" role="tab" aria-selected="true">Xác thực Email</a>
                        </li>
                     </ul>
                     <!-- Tab panes -->
                     <div class="tab-content">
                        <div class="tab-pane active show" id="post" role="tabpanel">
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="card">
                                    <div class="card-header">
                                       <div class="row align-items-center">
                                          <div class="col">
                                             <h4 class="card-title">Lịch sử đăng nhập</h4>
                                          </div>
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
                                                   <th>Nội Dung</th>
                                                   <th>Thời Gian</th>
                                                   <th>Thiết Bị</th>
                                                   <th>Trình Duyệt</th>
                                                   <th>Ip</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php 
                                                   $i = 1;
                                                   foreach($ketnoi->get_list("SELECT * FROM `his_login` WHERE `username` = '$username' ORDER BY `id` DESC LIMIT 10") as $list_his_login):?>
                                                <tr>
                                                   <td><a href="ecommerce-order-details.html">#<?=$i++;?></a></td>
                                                   <td>
                                                      <p class="d-inline-block align-middle mb-0">
                                                         <span class="d-block align-middle mb-0 product-name text-body"><?=$list_his_login['title'];?></span>
                                                      </p>
                                                   </td>
                                                   <td><?=fmDate($list_his_login['time']);?></td>
                                                   <td><?=$list_his_login['device'];?></td>
                                                   <td>
                                                      <span class="badge bg-success-subtle text-success"><i class="fas fa-check me-1"></i> <?=$list_his_login['browser'];?></span>
                                                   </td>
                                                   <td><?=$list_his_login['ip'];?></td>
                                                </tr>
                                                <?php endforeach;?>   
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!--end row--> 
                        </div>
                        <div class="tab-pane p-3" id="gallery" role="tabpanel">
                           <div id="grid" class="row g-0">
                              <div class="card">
                                 <div class="card-header">
                                    <h4 class="card-title">Đổi mật khẩu</h4>
                                 </div>
                                 <!--end card-header-->
                                 <div class="card-body">
                                    <!-- Mật khẩu cũ -->
                                    <!-- Mật khẩu cũ -->
                                    <div class="form-group row password-old">
                                       <label class="col-xl-3 col-lg-3 text-end align-self-center form-label">Mật khẩu cũ</label>
                                       <div class="col-lg-9 col-xl-8">
                                          <input class="form-control" type="password" id="password-old" placeholder="Nhập mật khẩu cũ">
                                          <i class="fa-solid fa-eye toggle-password" data-target="password-old"></i>
                                          <a href="#" class="text-primary font-12">Quên mật khẩu?</a>
                                       </div>
                                    </div>
                                    <!-- Mật khẩu mới -->
                                    <div class="form-group row password-new">
                                       <label class="col-xl-3 col-lg-3 text-end align-self-center form-label">Mật khẩu mới</label>
                                       <div class="col-lg-9 col-xl-8">
                                          <input class="form-control" type="password" id="password-new" placeholder="Nhập mật khẩu mới">
                                          <i class="fa-solid fa-eye toggle-password" data-target="password-new"></i>
                                       </div>
                                    </div>
                                    <!-- Nhập lại mật khẩu -->
                                    <div class="form-group row password-cf">
                                       <label class="col-xl-3 col-lg-3 text-end align-self-center form-label">Nhập lại mật khẩu mới</label>
                                       <div class="col-lg-9 col-xl-8">
                                          <input class="form-control" type="password" id="password-cf" placeholder="Nhập lại mật khẩu">
                                          <i class="fa-solid fa-eye toggle-password" data-target="password-cf"></i>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <div class="col-lg-9 col-xl-8 offset-lg-3">
                                          <button type="submit" class="btn btn-primary" id="btnChangePass">Thay đổi mật khẩu</button>
                                          <button type="button" class="btn btn-danger">Quay về</button>
                                       </div>
                                    </div>
                                 </div>
                                 <!--end card-body-->
                              </div>
                              <!--end card-->
                           </div>
                        </div>
                        <div class="tab-pane p-3" id="veri_email" role="tabpanel">
                           <div id="grid" class="row g-0">
                              <div class="card shadow-sm border-0">
                                 <div class="card-header bg-primary-subtle border-bottom">
                                    <h4 class="card-title mb-0 text-primary">
                                       <i class="fa-solid fa-envelope-circle-check me-1"></i> Xác thực Email
                                    </h4>
                                 </div>
                                 <div class="card-body">
                                    <div class="form-group row mb-3">
                                       <label class="col-xl-3 col-lg-3 text-end align-self-center form-label fw-semibold">
                                          Nhập mã xác thực
                                       </label>
                                       <div class="col-lg-9 col-xl-8">
                                          <input class="form-control shadow-sm" type="number" id="otpEmail" min="1" max="999999" placeholder="Nhập mã gồm 6 chữ số...">
                                          <div class="alert alert-info d-flex align-items-center mt-2 py-2 mb-0" role="alert" style="font-size: 14px;">
                                             <i class="fa-solid fa-circle-info me-2 text-info"></i>
                                             <div>
                                                Mã xác thực được gửi đến <strong>email của bạn</strong> và sẽ <span class="fw-semibold text-danger">hết hạn sau 5 phút</span>.  
                                                Vui lòng kiểm tra hộp thư đến hoặc thư rác.
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                       <div class="col-lg-9 col-xl-8 offset-lg-3">
                                          <button type="button" class="btn btn-outline-primary me-2" id="btnSendMail">
                                             <i class="fa-solid fa-paper-plane me-1"></i> Gửi mã
                                          </button>
                                          <button type="button" class="btn btn-success" id="btnVeriMail">
                                             <i class="fa-solid fa-shield-halved me-1"></i> Xác thực
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane p-3 " id="settings" role="tabpanel">
                           <div class="card">
                              <div class="card-header">
                                 <h4 class="card-title">Thông Báo Đăng Nhập</h4>
                              </div>
                              <div class="card-body">
                                 <div class="form-check">
                                    <input class="form-check-input" 
                                       type="checkbox" 
                                       id="Email_Notifications"
                                       <?= $user['tb_email'] == 'on' ? 'checked' : '' ?>
                                       onchange="updateNotification('email', this.checked)">
                                    <label class="form-check-label">Thông báo qua Email</label>
                                 </div>
                                 <div class="form-check mt-2">
                                    <input class="form-check-input" 
                                       type="checkbox" 
                                       id="Tele_Notifications"
                                       <?= $user['tb_tele'] == 'on' ? 'checked' : '' ?>
                                       onchange="updateNotification('tele', this.checked)">
                                    <label class="form-check-label">Thông báo qua Tele</label>
                                 </div>
                                 <div class="form-check mt-2 d-flex align-items-center">
                                    <label class="form-check-label mb-0">
                                    Cập nhật ID Tele 
                                    (<a href="https://shopee.vn" target="_blank" class="text-primary text-decoration-none">
                                    Liên kết ngay
                                    </a>)
                                    </label>
                                    <button type="button" class="btn btn-primary ms-auto" id="id_tele">
                                    Liên kết Tele
                                    </button>
                                 </div>
                                 <div class="modal fade" id="teleModal" tabindex="-1" aria-labelledby="teleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                       <div class="modal-content border-0 shadow-lg">
                                          <div class="modal-header bg-primary bg-opacity-10">
                                          <h5 class="modal-title fw-bold text-primary" id="teleModalLabel">
                                             <i class="fa-brands fa-telegram me-2"></i> Liên kết tài khoản Telegram
                                          </h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                          </div>
                                          <div class="modal-body">
                                          <p class="text-muted mb-3">
                                             Để nhận thông báo qua Telegram, vui lòng nhập <strong>ID Telegram</strong> của bạn.
                                             Bạn có thể lấy ID bằng cách trò chuyện với bot <a href="https://t.me/chinhapic_bot" target="_blank" class="text-decoration-none fw-semibold">@chinhapic_bot</a>.
                                          </p>
                                          <div class="form-group">
                                             <label for="tele_id_input" class="form-label fw-semibold">
                                                ID Telegram của bạn
                                             </label>
                                             <input
                                                type="text"
                                                id="tele_id_input"
                                                class="form-control shadow-sm"
                                                placeholder="<?=$user['id_tle'] ?? 'Chưa liên kết';?>"
                                             >
                                          </div>

                                          <!-- 💡 Lưu ý nhỏ -->
                                          <div class="alert alert-info d-flex align-items-center mt-3 py-2 mb-0" role="alert" style="font-size: 14px;">
                                             <i class="fa-solid fa-circle-info me-2 text-info"></i>
                                             <div>
                                                Sau khi nhập ID, nhấn <strong>Lưu</strong> để xác nhận liên kết.<br>
                                                Bạn có thể huỷ liên kết bất kỳ lúc nào.
                                             </div>
                                          </div>
                                          </div>

                                          <div class="modal-footer">
                                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                             <i class="fa-solid fa-xmark me-1"></i> Đóng
                                          </button>
                                          <button type="button" class="btn btn-primary" id="btnSaveTele">
                                             <i class="fa-solid fa-floppy-disk me-1"></i> Lưu
                                          </button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane p-3 " id="api_token" role="tabpanel">
                           <div id="grid" class="row g-0">
                              <div class="card">
                                 <div class="card-header">
                                    <h4 class="card-title">API Token</h4>
                                 </div>
                                 <!--end card-header-->
                                 <div class="card-body">
                                    <div class="form-group row api_token">
                                       <label class="col-xl-3 col-lg-3 text-end align-self-center form-label">API Token hiện tại</label>
                                       <div class="col-lg-9 col-xl-9 position-relative" >
                                          <input class="form-control pe-5" type="text" id="api_token_input" 
                                             value="<?= !empty($user['token']) ? decodecryptData($user['token']) : 'Chưa cập nhật'; ?>">
                                          <i
                                             class="fa-solid fa-copy copy-icon"
                                             id="btnCopyToken"
                                             title="Sao chép token"
                                             ></i>
                                       </div>
                                       <div class="form-group row">
                                          <div class="col-lg-10 col-xl-9 offset-lg-10">
                                             <button type="submit" class="btn btn-primary" id="btnChangeApi">Thay đổi Token </button>
                                          </div>
                                       </div>
                                    </div>
                                    <!--end card-body-->
                                 </div>
                                 <!--end card-->
                              </div>
                           </div>
                           <!--end card-->
                        </div>
                     </div>
                  </div>
                  <!-- end col --> 
               </div>
               <!--end row--> 
            </div>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
         </div>
      </div>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
   </body>
   <script>
      $(document).ready(function () {
        $('#id_tele').on('click', function () {
          const modal = new bootstrap.Modal(document.getElementById('teleModal'));
          modal.show();
        });
        $('#btnSaveTele').on('click', function () {
          const idTele = $('#tele_id_input').val().trim();
          if (!idTele) {
            Swal.fire('Thông báo', 'Vui lòng nhập ID Telegram!', 'warning');
            return;
          }
          $.ajax({
            url: '/ajax/auth/update-tb.php',
            type: 'POST',
            dataType: 'json',
            data: {
              action: 'update-tb',
              id_tele: idTele
            },
            success: function (res) {
              if (res.status === 'success') {
                Swal.fire('Thành công', 'Đã lưu ID Telegram thành công!', 'success');
                $('#teleModal').modal('hide');
              } else {
                Swal.fire('Lỗi', res.msg || 'Không thể lưu ID Telegram', 'error');
              }
            },
            error: function () {
              Swal.fire('Lỗi', 'Không thể kết nối đến máy chủ', 'error');
            }
          });
        });
      
      });
   </script>
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
      $(document).ready(function() {
      const $btnChangePass = $('#btnChangePass');
      const btnChangePass = async () => {
      try {
          $btnChangePass.prop('disabled', true)
              .html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang Xử Lý...');
          const passwordOld = $('#password-old').val();
          const passwordNew = $('#password-new').val();
          const passwordCf = $('#password-cf').val();
          const res = await $.ajax({
              url: '/ajax/auth/changepass',
              type: 'POST',
              dataType: 'json',
              data: { action: 'CHANGE_PASS', passwordOld, passwordNew,passwordCf },
          });
          if (res.status === 'success') {
              showAlert('Thành công', 'Đổi mật khẩu thành công', 'success');
              setTimeout(() => {
                  window.location.href = '/home';
              }, 1500);
          } else {
              showAlert('Thất bại', res.msg, 'error');
          }
      } catch (err) {
          console.error(err);
      } finally {
          $btnChangePass.prop('disabled', false).html('Đổi mật khẩu');
      }
      };
      $btnChangePass.on('click', btnChangePass);
      $(document).on('keypress', function(e) {
      if (e.which === 13) {
          btnChangePass();
      }
      });
      });
      $(document).ready(function() {
         const $btnSendMail = $('#btnSendMail');
         const btnSendMail = async () => {
            try {
               $btnSendMail.prop('disabled', true)
                  .html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang Xử Lý...');
               const res = await $.ajax({
                  url: '/ajax/auth/veri_email.php',
                  type: 'POST',
                  dataType: 'json',
                  data: { action: 'SEND_MAIL' },
               });
               if (res.status === 'success') {
                  showAlert('Thành công', 'Mã đã được gửi về mail', 'success');
                  setTimeout(() => {
                     window.location.reload();
                  }, 1000);
               } else {
                  showAlert('Thất bại', res.msg || 'Không thể gửi mã', 'error');
               }
            } catch (err) {
               showAlert('Lỗi', 'Đã xảy ra lỗi trong quá trình xử lý', 'error');
            } finally {
               $btnSendMail.prop('disabled', false).html('Gửi mã');
            }
         };
         $btnSendMail.on('click', btnSendMail);
      });
      $(document).ready(function() {
         const $btnVeriMail = $('#btnVeriMail');
         const btnVeriMail = async () => {
            try {
               $btnVeriMail.prop('disabled', true)
                  .html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang Xử Lý...');
               const otpEmail = $('#otpEmail').val();
               const res = await $.ajax({
                  url: '/ajax/auth/veri_email.php',
                  type: 'POST',
                  dataType: 'json',
                  data: { action: 'VERI_MAIL', otpEmail },
               });
               if (res.status === 'success') {
                  showAlert('Thành công', 'Mã đã được xác thực', 'success');
                  setTimeout(() => {
                     window.location.reload();
                  }, 1000);
               } else {
                  showAlert('Thất bại', res.msg || 'Không thể xác thực mã', 'error');
                  $btnVeriMail.prop('disabled', false).html('Xác thực');
               }
               } catch (err) {
                  showAlert('Lỗi', 'Đã xảy ra lỗi trong quá trình xử lý', 'error');
                  $btnVeriMail.prop('disabled', false).html('Xác thực');
               } 
         };
         $btnVeriMail.on('click', btnVeriMail);
      })
   </script>
   <script>
      function updateNotification(type, checked) {
        let status = checked ? 'on' : 'off'; 
        $.ajax({
          url: '/ajax/auth/update_notification',
          type: 'POST',
          dataType: 'json', 
          data: {
            action: type,    
            status: status    
          },
          success: function(res) {
            if (res.status === 'success') {
              showAlert('Thành công', 'Cập nhật trạng thái thông báo thành công', 'success');
              setTimeout(() => {
                  window.location.reload();
              }, 200);
      
            } else {
              showAlert('Thất bại', res.msg || 'Cập nhật thất bại', 'error');
                setTimeout(() => {
                $('#settings').load('/client/profile #settings > *');
            }, 200);}
          },
          error: function(xhr, status, error) {
            showAlert('Lỗi', 'Không thể kết nối đến máy chủ: ' + error, 'error');
          }
        });
      }
   </script>
   <script>
      document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', function() {
          const input = document.getElementById(this.dataset.target);
          if (input.type === 'password') {
            input.type = 'text';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
          } else {
            input.type = 'password';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
          }
        });
      });
   </script>
   <style>
      .position-relative {
      position: relative;
      }
      .copy-icon {
      position: absolute;
      top: 50%;
      right: 25px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #6c757d;
      transition: color 0.2s ease;
      z-index: 10;
      }
      .copy-icon:hover {
      color: #0d6efd;
      }
      #btnChangeApi{
      margin-top: 10px;
      }
   </style>
   <script>
      function showAlert(title = '', text = '', icon = '') {
        Swal.fire({
          title, text, icon,
          confirmButtonText: 'OK',
          customClass: { confirmButton: 'btn btn-primary' },
          buttonsStyling: false
        });
      }
      
      $(document).ready(function () {
      const $btnChangeApi = $('#btnChangeApi');
      const $inputToken = $('#api_token_input');
      const $btnCopyToken = $('#btnCopyToken');
       $btnCopyToken.on('click', function () {
        const token = $inputToken.val().trim();
        if (!token) return;
        navigator.clipboard.writeText(token)
          .then(() => {
            $(this).removeClass('fa-copy text-muted').addClass('fa-check text-success');
            setTimeout(() => {
              $(this).removeClass('fa-check text-success').addClass('fa-copy text-muted');
            }, 1500);
          })
          .catch(() => {
            Swal.fire('Lỗi', 'Không thể sao chép token', 'error');
          });
      });
      const handleChangeApi = async () => {
        try {
          $btnChangeApi.prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang xử lý...');
      
          const res = await $.ajax({
            url: '/ajax/auth/change_api_token.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'CHANGE_API_TOKEN' }
          });
      
          if (res.status === 'success') {
            showAlert('Thành công', 'Đã tạo API Token mới', 'success');
            setTimeout(() => {
                      window.location.reload();
                  }, 200);
          } else {
            showAlert('Thất bại', res.msg || 'Không thể tạo token mới', 'error');
          }
        } catch (err) {
          console.error(err);
          showAlert('Lỗi', 'Đã xảy ra lỗi trong quá trình xử lý', 'error');
        } finally {
          $btnChangeApi.prop('disabled', false).html('Thay đổi');
        }
      };
      
      $btnChangeApi.on('click', handleChangeApi);
      });
      
   </script>
   <style>
      .toggle-password {
      position: absolute;
      top: 50%;
      right: 25px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #888;
      font-size: 10px;
      }
      .toggle-password:hover {
      color: #eee;
      }
      .form-group.password-old {
      top: 50%;
      }
      .form-group.password-old .col-lg-9 {
      position: relative;
      }
      .form-group.password-old a {
      display: block;
      font-size: 12px;
      margin-top: 6px;
      color: #5e72e4;
      text-decoration: none;
      }
      .form-group.password-old a:hover {
      text-decoration: underline;
      }
      .form-group.password-old .toggle-password {
      top: 36%;
      }
      .form-group.password-new,
      .form-group.password-cf {
      margin-bottom: 20px;
      }
      .form-group.password-new .col-lg-9,
      .form-group.password-cf .col-lg-9 {
      position: relative;
      }
      .form-group.password-new .toggle-password,
      .form-group.password-cf .toggle-password {
      top: 50%;
      }
   </style>
</html>
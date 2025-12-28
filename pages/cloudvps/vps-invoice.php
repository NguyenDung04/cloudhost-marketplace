<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <title>Trang Chủ | APIIT</title>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <?php
      $id_invoice = antixss($_GET['id']);
      $check = $ketnoi->get_row("SELECT * FROM `invoices` WHERE `id` = '$id_invoice' AND `username` = '$username'");
      $id_oder = $check['id_oder'];
      $order = $ketnoi->get_row("SELECT * FROM `orders` WHERE `code` = '$id_oder'");
      $username = $order['username'];
      // $check_vps = $ketnoi->get_row("SELECT * FROM `purchased_cloudvps` WHERE `id_vps` = '$id_vps' AND `username` = '$username'");
      $check_u = $ketnoi->get_row("SELECT * FROM `users` WHERE `username` = '$username'");
      if (!$check) {
         header("Location: /404");
         exit();
      }
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
                        <h4 class="page-title">Hóa đơn
                        </h4>
                        <div class="">
                           <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item">
                                 <a href="#"><i class="fa-solid fa-house me-1"></i> Trang Chủ</a>
                              </li>
                              <li class="breadcrumb-item">
                                 <a href="#"><i class="fa-solid fa-file-invoice me-1"></i> Quản Lý Hóa Đơn</a>
                              </li>
                              <li class="breadcrumb-item active">
                                 <i class="fa-solid fa-receipt me-1"></i> Hóa Đơn
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
                  <div class="col-12">
                     <div class="card">
                        <!-- Header -->
                        <div class="card-body bg-dark text-white rounded-top">
                           <div class="row align-items-center">
                              <div class="col-4">
                                 <img src="https://mannatthemes.com/dastone-bs5/default/assets/images/logo-sm.png" 
                                    alt="logo-small" height="60"> 
                              </div>
                              <div class="col-8 text-end">
                                 <h5 class="mb-1"><span class="text-muted">Mã hóa đơn:</span> #<?=$check['id'];?></h5>
                                 <h5 class="mb-0"><span class="text-muted">Ngày thanh toán:</span> <?=fmDate($order['created_at']);?></h5>
                              </div>
                           </div>
                        </div>
                        <!-- Body -->
                        <div class="card-body">
                           <!-- Nhà cung cấp & Khách hàng -->
                           <div class="table-responsive mb-4">
                              <table class="table table-bordered">
                                 <thead class="table-light">
                                    <tr>
                                       <th>Nhà cung cấp dịch vụ</th>
                                       <th>Thông tin khách hàng</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>
                                          <h6 class="mb-1">ChinhApi Cloud Server VMware HCI</h6>
                                          <p class="mb-0">Địa chỉ: Nam Dương , Nam Trực , Nam Định</p>
                                          <p class="mb-0">SĐT: 0388.674.883</p>
                                          <p class="mb-0">Email: admin@chinhapi.com</p>
                                       </td>
                                       <td>
                                          <h6 class="mb-1"><?=$check_u['fullname'];?></h6>
                                          <p class="mb-0">Địa chỉ: <?=$check_u['address'];?></p>
                                          <p class="mb-0">SĐT: <?=$check_u['phone'];?></p>
                                          <p class="mb-0">Email: <?=$check_u['email'];?></p>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                           <!-- Chi tiết đơn hàng -->
                           <div class="table-responsive mb-4">
                              <table class="table table-bordered">
                                 <thead class="table-light">
                                    <tr>
                                       <th>Mô tả chi tiết</th>
                                       <th>Thời gian</th>
                                       <th>Số tiền</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td><?=$check['title'];?> : (<?=$order['name'];?>)</td>
                                       <td><?=check_Month($order['billing_cycle']);?></td>
                                       <td><?=money($order['total_money']);?> VNĐ</td>
                                    </tr>
                                    <tr>
                                       <td colspan="2" class="text-end fw-bold">Số lượng</td>
                                       <td><?=$order['quantity'];?></td>
                                    </tr>
                                    <tr>
                                       <td colspan="2" class="text-end fw-bold">Thành tiền</td>
                                       <td class="fw-bold text-danger"><?=money($order['total_money']);?>đ</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                           <!-- Ghi chú / Chữ ký -->
                           <div class="row">
                              <div class="col-lg-6">
                                 <h6>Điều khoản:</h6>
                                 <ul class="ps-3">
                                    <li><small>Thanh toán trong vòng 7 ngày kể từ khi nhận hóa đơn.</small></li>
                                    <li><small>Có thể thanh toán qua chuyển khoản hoặc thẻ.</small></li>
                                    <li><small>Quá hạn sẽ tính phí phạt theo quy định.</small></li>
                                 </ul>
                              </div>
                              <div class="col-lg-6 text-end">
                                 <small>Người phụ trách</small><br>
                                 <img src="https://chukydep.vn/Upload/post/chu-ky-chu-c.jpg" alt="signature" height="50" class="my-2"  style="position: relative; left: -20px;">
                              </div>
                           </div>
                           <hr>
                           <!-- Footer -->
                           <div class="row">
                              <div class="col-lg-6">
                                 <small class="text-muted">Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</small>
                              </div>
                              <div class="col-lg-6 text-end">
                                 <a href="javascript:window.print()" class="btn btn-info btn-sm">In</a>
                                 <a href="#" class="btn btn-danger btn-sm">Quay Lại</a>
                              </div>
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
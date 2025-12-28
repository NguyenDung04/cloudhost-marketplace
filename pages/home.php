<!DOCTYPE html>
<html lang="vi" dir="ltr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ | APIIT</title>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
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
                        <h4 class="page-title">Trang Chủ</h4>
                        <div class="">
                           <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item">
                                 <a href="#"><i class="fa-solid fa-database me-1"></i> <?=$ketnoi->site('site_name');?></a>
                              </li>
                             
                              <li class="breadcrumb-item active">
                              <i class="fa-solid fa-house me-1"></i></i> Trang Chủ
                              </li>
                           </ol>
                        </div>
                     </div>
                  </div>
               </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-0 text-center img-bg rounded-top" style="height:120px;"></div>
                            <div class="position-relative text-center mt-n5">
                                <img src="/core/upload/images/avata_user.jpg"
                                     class="rounded-circle border border-3 border-white" width="100" alt="avatar">
                                <h5 class="mt-3 mb-0 fw-bold">Xin Chào, Nguyễn Chính</h5>
                                <p class="text-muted">@<?=$username;?></p>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="iconoir-language text-muted me-2"></i>
                                    <span class="fw-semibold text-body">Cấp Bậc:</span> <?=level($user['level']);?>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="iconoir-mail-out text-muted me-2"></i>
                                    <span class="fw-semibold text-body">Email:</span>
                                    <a href="mailto:<?=$user['email'];?>" class="ms-1 text-primary"><?=$user['email'];?></a>
                                </div>

                                <h6 class="text-secondary fw-semibold mb-2">Kết nối mạng xã hội</h6>
                                <div class="d-flex gap-2">
                                    <a href="https://facebook.com/sharer/sharer.php?u=https://yourlink.com" 
                                       class="btn btn-outline-primary btn-sm rounded-circle">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    <a href="https://t.me/share/url?url=https://yourlink.com" 
                                       class="btn btn-outline-info btn-sm rounded-circle">
                                        <i class="fa-brands fa-telegram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bên phải -->
                    <div class="col-lg-8">
                        <!-- Thông báo hệ thống -->
                        <div class="alert alert-primary border-dashed py-2 mb-3" role="alert">
                            <img src="/assets/images/extra/party.gif" alt="" height="28" class="me-1">
                            <strong>Admin:</strong> Hệ thống đang vận hành bình thường. Nếu có điều gì bất thường... có lẽ do vũ trụ đang thử thách bạn 😄. 
                            Hãy F5 nhẹ và tiếp tục công việc nhé!
                        </div>
                        <div class="row g-3">
                            <?php
                            $total_order = $ketnoi->num_rows("SELECT * FROM `orders` WHERE `username` = '$username'");
                            $total_vps = $ketnoi->num_rows("SELECT * FROM `purchased_cloudvps` WHERE `username` = '$username'");
                            $total_hosting = $ketnoi->num_rows("SELECT * FROM `history_buy_hosting` WHERE `username` = '$username'");
                            $total = $total_vps + $total_hosting;
                            $stats = [
                                ['icon' => 'iconoir-dollar-circle', 'color' => 'info', 'title' => 'Số Dư', 'value' => money($user['money']).' <span class="fs-11 text-muted">Vnđ</span>'],
                                ['icon' => 'iconoir-cart', 'color' => 'primary', 'title' => 'Tổng Đơn', 'value' => $total_order.' <span class="fs-11 text-muted">Đơn</span>'],
                                ['icon' => 'iconoir-thumbs-up', 'color' => 'success', 'title' => 'Đang Sử Dụng', 'value' => $total.' <span class="fs-11 text-muted">VPS</span>'],
                                ['icon' => 'iconoir-xmark-circle', 'color' => 'danger', 'title' => 'Chờ Gia Hạn', 'value' => '0 <span class="fs-11 text-muted">VPS</span>'],
                            ];
                            foreach ($stats as $s): ?>
                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow-sm hover-lift">
                                    <div class="card-body d-flex align-items-center">
                                        <i class="<?=$s['icon'];?> fs-24 text-<?=$s['color'];?> me-3"></i>
                                        <div>
                                            <p class="mb-0 fw-semibold"><?=$s['title'];?></p>
                                            <h5 class="fw-bold mb-0"><?=$s['value'];?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="card mt-3 border-0 shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Hướng Dẫn</h5>
                                <a href="/client/blogs" class="btn btn-outline-primary btn-sm">
                                    <i class="fa-solid fa-eye me-1"></i> View All
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="#">#131123</a></td>
                                            <td>
                                                <strong>Hướng Dẫn Mở Rộng Ổ Cứng Trên Linux</strong><br>
                                                <small class="text-muted">Người đăng: admin</small>
                                            </td>
                                            <td>15/08/2023</td>
                                        </tr>
                                        <tr>
                                            <td><a href="#">#632536</a></td>
                                            <td>
                                                <strong>Hướng Dẫn Tạo Proxy Trên Linux</strong><br>
                                                <small class="text-muted">Người đăng: admin</small>
                                            </td>
                                            <td>15/08/2023</td>
                                        </tr>
                                    </tbody>
                                </table>
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
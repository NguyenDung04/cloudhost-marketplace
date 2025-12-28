<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <title>Tiếp Thị Liên Kết | APIIT</title>
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
                        <h4 class="page-title">Tiếp Thị Liên Kết</h4>
                        <div class="">
                           <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item">
                                 <a href="#">
                                 <i class="fa-solid fa-database me-1"></i> ChinhApi
                                 </a>
                              </li>
                              <li class="breadcrumb-item">
                                 <a href="/">
                                 <i class="fa-solid fa-house me-1"></i> Trang Chủ
                                 </a>
                              </li>
                              <li class="breadcrumb-item active">
                                 <i class="fa-solid fa-link me-1"></i> Tiếp Thị Liên Kết
                              </li>
                           </ol>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-9">
                     <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-3">
                           <div class="card report-card">
                              <div class="card-body">
                                 <div class="row d-flex justify-content-center">
                                    <div class="col">
                                       <p class="text-dark mb-0 fw-semibold">Lượt Click</p>
                                       <h3 class="my-1 fs-20">24,000</h3>
                                    </div>
                                    <div class="col-auto align-self-center">
                                       <div class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle">
                                          <i class="iconoir-user fs-4"></i>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="card report-card">
                              <div class="card-body">
                                 <div class="row d-flex justify-content-center">
                                    <div class="col">
                                       <p class="text-dark mb-0 fw-semibold">Số dư hoa hồng</p>
                                       <h3 class="my-1 fs-20">1,000,000 VNĐ</h3>
                                    </div>
                                    <div class="col-auto align-self-center">
                                       <div class="flex-shrink-0 bg-info-subtle text-info thumb-md rounded-circle">
                                          <i class="iconoir-clock fs-4"></i>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="card report-card">
                              <div class="card-body">
                                 <div class="row d-flex justify-content-center">
                                    <div class="col">
                                       <p class="text-dark mb-0 fw-semibold">Số tiền đã rút</p>
                                       <h3 class="my-1 fs-20">1,000,000 VNĐ</h3>
                                    </div>
                                    <div class="col-auto align-self-center">
                                       <div class="flex-shrink-0 bg-pink-subtle text-pink thumb-md rounded-circle">
                                          <i class="iconoir-activity fs-4"></i>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="card report-card">
                              <div class="card-body">
                                 <div class="row d-flex justify-content-center">
                                    <div class="col">
                                       <p class="text-dark mb-0 fw-semibold">Giao dịch hoàn thành</p>
                                       <h3 class="my-1 fs-20">10</h3>
                                    </div>
                                    <div class="col-auto align-self-center">
                                       <div class="flex-shrink-0 bg-warning-subtle text-warning thumb-md rounded-circle">
                                          <i class="iconoir-handbag fs-4"></i>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>                             
                     </div>
                     <div class="card">
                        <div class="card-header">
                           <div class="row align-items-center">
                              <div class="col">
                                 <h4 class="card-title">Thống kê tiếp thị</h4>
                              </div>
                              <div class="col-auto">
                                 <div class="dropdown">
                                    <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tuần<i class="las la-angle-down ms-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                       <a class="dropdown-item" href="#">Tuần</a>
                                       <a class="dropdown-item" href="#">Tháng</a>
                                       <a class="dropdown-item" href="#">Năm</a>
                                    </div>
                                 </div>
                              </div>
                           </div>                            
                        </div>
                        <div class="card-body">
                           <div class="">
                              <div id="ana_dash_1" class="apex-charts"></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="alert alert-warning shadow-sm border-theme-white-2" role="alert">
                        <div class="d-inline-flex justify-content-center align-items-center thumb-xs bg-warning rounded-circle mx-auto me-1">
                           <i class="fas fa-exclamation align-self-center mb-0 text-white "></i>
                        </div>
                        <strong>Lưu ý !</strong> Chia sẻ liên kết này lên mạng xã hội hoặc bạn bè của bạn.
                     </div>
                     <div class="card">
                        <div class="card-header">
                           <div class="row align-items-center">
                              <div class="col">
                                 <h4 class="card-title mb-0">Thông Tin Tiếp Thị</h4>
                              </div>
                           </div>
                        </div>
                        <div class="card-body">
                           <div class="input-group mb-3">
                              <input type="text" class="form-control" id="affiliateLink" value="https://chinhapi.com/ref/12345" readonly>
                              <button class="btn btn-outline-primary" type="button" onclick="copyAffiliateLink()">
                              <i class="fa-solid fa-copy"></i> Copy
                              </button>
                           </div>
                           <div class="d-flex gap-2 mb-3">
                              <a href="https://www.facebook.com/sharer/sharer.php?u=https://chinhapi.com/ref/12345" target="_blank" class="btn btn-primary">
                              <i class="fa-brands fa-facebook-f"></i> Facebook
                              </a>
                              <a href="https://twitter.com/intent/tweet?url=https://chinhapi.com/ref/12345" target="_blank" class="btn btn-info text-white">
                              <i class="fa-brands fa-x-twitter"></i> Twitter
                              </a>
                              <a href="https://www.instagram.com/" target="_blank" class="btn btn-danger">
                              <i class="fa-brands fa-instagram"></i> Instagram
                              </a>
                           </div>
                           <button class="btn btn-success w-100">
                           <i class="fa-solid fa-money-bill-wave"></i> Rút Tiền
                           </button>
                        </div>
                     
                     </div>
                  </div>
                  <script>
                    function copyAffiliateLink() {
                        var copyText = document.getElementById("affiliateLink");
                        copyText.select();
                        copyText.setSelectionRange(0, 99999);
                        navigator.clipboard.writeText(copyText.value).then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Đã copy link!',
                            text: copyText.value,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        });
                    }
                </script>
               </div>
            </div>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="Appearance" aria-labelledby="AppearanceLabel">
               <div class="offcanvas-header border-bottom justify-content-between">
                  <h5 class="m-0 font-14" id="AppearanceLabel">Appearance</h5>
                  <button type="button" class="btn-close text-reset p-0 m-0 align-self-center" data-bs-dismiss="offcanvas" aria-label="Close"></button>
               </div>
               <div class="offcanvas-body">
                  <h6>Account Settings</h6>
                  <div class="p-2 text-start mt-3">
                     <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch1">
                        <label class="form-check-label" for="settings-switch1">Auto updates</label>
                     </div>
                     <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch2" checked>
                        <label class="form-check-label" for="settings-switch2">Location Permission</label>
                     </div>
                     <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch3">
                        <label class="form-check-label" for="settings-switch3">Show offline Contacts</label>
                     </div>
                  </div>
                  <h6>General Settings</h6>
                  <div class="p-2 text-start mt-3">
                     <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch4">
                        <label class="form-check-label" for="settings-switch4">Show me Online</label>
                     </div>
                     <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch5" checked>
                        <label class="form-check-label" for="settings-switch5">Status visible to all</label>
                     </div>
                     <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch6">
                        <label class="form-check-label" for="settings-switch6">Notifications Popup</label>
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
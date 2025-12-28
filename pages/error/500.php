<!DOCTYPE html>
<html lang="vi" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <title>500 | APIIT</title>
   </head>
   <body>
      <div class="container-xxl">
         <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
               <div class="card-body">
                  <div class="row">
                     <div class="col-lg-4 mx-auto">
                        <div class="card">
                           <div class="card-body p-0 bg-black auth-header-box rounded-top">
                              <div class="text-center p-3">
                                 <a href="/home" class="logo logo-admin">
                                    <img src="https://mannatthemes.com/dastone-bs5/default/assets/images/logo-sm.png" height="50" alt="logo" class="auth-logo">
                                 </a>
                                 <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Xin lỗi! Đã xảy ra lỗi máy chủ bất ngờ</h4>
                                 <p class="text-muted fw-medium mb-0">Quay lại trang quản trị APIIT</p>
                              </div>
                           </div>
                           <div class="card-body">
                              <div class="ex-page-content text-center">
                                 <img src="https://mannatthemes.com/dastone-bs5/default/assets/images/extra/error.svg" alt="500" height="170">
                                 <h1 class="my-2">500!</h1>
                                 <h5 class="fs-16 text-muted mb-3">Lỗi máy chủ nội bộ</h5>
                                 <p class="text-muted mb-4">
                                    Máy chủ gặp sự cố khi xử lý yêu cầu của bạn.  
                                    Vui lòng thử lại sau hoặc liên hệ quản trị viên để được hỗ trợ.
                                 </p>
                              </div>
                              <a class="btn btn-primary w-100" href="/home">
                                 Quay lại trang chủ <i class="fas fa-redo ms-1"></i>
                              </a>
                           </div><!--end card-body-->
                        </div><!--end card-->
                     </div><!--end col-->
                  </div><!--end row-->
               </div><!--end card-body-->
            </div><!--end col-->
         </div><!--end row-->
      </div><!-- container -->
   </body>
</html>
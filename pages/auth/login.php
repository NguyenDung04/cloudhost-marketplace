<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <title>Đăng Nhập | APIIT</title>
   </head>
   <body >
      <div class="container-xxl">
         <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
               <div class="card-body">
                  <div class="row">
                     <div class="col-lg-4 mx-auto">
                        <div class="card">
                           <div class="card-body p-0 bg-black auth-header-box rounded-top">
                              <div class="text-center p-3">
                                 <a href="index.html" class="logo logo-admin">
                                 <img src="https://mannatthemes.com/dastone-bs5/default/assets/images/logo-sm.png" height="50" alt="logo" class="auth-logo">
                                 </a>
                                 <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Đăng Nhập</h4>
                                 <p class="text-muted fw-medium mb-0">Đăng nhập tài khoản .</p>
                              </div>
                           </div>
                           <div class="card-body">
                              <form class="my-4" action="index.html">
                                 <div class="form-group mb-2">
                                    <label class="form-label" >Tài khoản</label>
                                    <input type="text" class="form-control" id="username" placeholder="Nhập tài khoản">                               
                                 </div>
                                 <!--end form-group--> 
                                 <div class="form-group">
                                    <label class="form-label" >Mật khẩu</label>                                            
                                    <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu">   
                                    <i class="fa-solid fa-eye toggle-password" data-target="password"></i>
                                 </div>
                                 <!--end form-group--> 
                                 <div class="form-group row mt-3">
                                    <div class="col-sm-6">
                                       <div class="form-check form-switch form-switch-primary">
                                          <input class="form-check-input" type="checkbox" id="customSwitchPrimary">
                                          <label class="form-check-label" for="customSwitchPrimary">Lưu Mật Khẩu</label>
                                       </div>
                                    </div>
                                    <!--end col--> 
                                    <div class="col-sm-6 text-end">
                                       <a href="/auth/recover-pw" class="text-muted font-13"><i class="dripicons-lock"></i>Quên mật khẩu ?</a>                                    
                                    </div>
                                    <!--end col--> 
                                 </div>
                                 <!--end form-group--> 
                                 <div class="form-group mb-0 row">
                                    <div class="col-12">
                                       <div class="d-grid mt-3">
                                          <button class="btn btn-primary" type="button" id="btnLogin" >Đăng Nhập </button>
                                       </div>
                                    </div>
                                    <!--end col--> 
                                 </div>
                                 <!--end form-group-->                           
                              </form>
                              <!--end form-->
                              <div class="text-center  mb-2">
                                 <p class="text-muted">Chưa có tài khoản ?  <a href="/auth/register" class="text-primary ms-2">Đăng ký tài khoản</a></p>
                                 <h6 class="px-3 d-inline-block">Đăng nhập cách khác</h6>
                              </div>
                              <div class="d-flex justify-content-center">
                                 <a href="" class="d-flex justify-content-center align-items-center thumb-md bg-blue-subtle text-blue rounded-circle me-2">
                                 <i class="fab fa-facebook align-self-center"></i>
                                 </a>
                              </div>
                           </div>
                           <!--end card-body-->
                        </div>
                        <!--end card-->
                     </div>
                     <!--end col-->
                  </div>
                  <!--end row-->
               </div>
               <!--end card-body-->
            </div>
            <!--end col-->
         </div>
         <!--end row-->                                        
      </div>
      <!-- container -->
   </body>
   <?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
   <script>
      $(document).ready(function() {
      const $btnLogin = $('#btnLogin');
      const btnLogin = async () => {
          try {
              $btnLogin.prop('disabled', true)
                  .html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang Xử Lý...');
              const username = $('#username').val();
              const password = $('#password').val();
              const res = await $.ajax({
                  url: '/ajax/auth/login',
                  type: 'POST',
                  dataType: 'json',
                  data: { action: 'LOGIN', username, password },
              });
              if (res.status === 'success') {
                  showAlert('Thành công', 'Đăng nhập thành công', 'success');
                  setTimeout(() => {
                      window.location.href = '/home';
                  }, 1500);
              } else {
                  showAlert('Thất bại', res.msg, 'error');
              }
          } catch (err) {
              console.error(err);
          } finally {
              $btnLogin.prop('disabled', false).html('Đăng Nhập');
          }
      };
      $btnLogin.on('click', btnLogin);
      $(document).on('keypress', function(e) {
          if (e.which === 13) {
              btnLogin();
          }
      });
      });
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
      .form-group {
      position: relative; 
      }
      .toggle-password {
      position: absolute;
      top: 72%;
      right: 18px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #888;
      font-size: 10px;
      }
      .toggle-password:hover {
      color: #eee;
      }
   </style>
</html>
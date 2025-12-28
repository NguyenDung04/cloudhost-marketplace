
<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
    <head>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <title>Đăng Ký | APIIT</title>
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
                                        <a href="index.html" class="logo logo-admin">
                                            <img src="https://mannatthemes.com/dastone-bs5/default/assets/images/logo-sm.png" height="50" alt="logo" class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Đăng ký Tài Khoản</h4>   
                                        <p class="text-muted fw-medium mb-0">
                                        Nhập thông tin chi tiết của bạn để tạo tài khoản ngay.</p>  
                                    </div>
                                </div>
                                <div class="card-body">                                    
                                    <form class="my-4" >            
                                        <div class="form-group mb-2">
                                            <label class="form-label" >Tài khoản</label>
                                            <input type="text" class="form-control" id="username"  placeholder="Nhập tài khoản">                               
                                        </div><!--end form-group--> 

                                        <div class="form-group mb-2">
                                            <label class="form-label" >Email</label>
                                            <input type="email" class="form-control" id="email"  placeholder="Nhập email">                               
                                        </div><!--end form-group--> 
            
                                        <div class="form-group mb-2">
                                            <label class="form-label" >Mật khẩu</label>                                            
                                            <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu">
                                            <i class="fa-solid fa-eye toggle-password" data-target="password"></i>
                                        </div><!--end form-group--> 

                                        <div class="form-group mb-2">
                                            <label class="form-label" >Nhập lại mật khẩu</label>                                            
                                            <input type="password" class="form-control"id="confirmpassword" placeholder="Nhập lại mật khẩu"> 
                                            <i class="fa-solid fa-eye toggle-password" data-target="confirmpassword"></i>
                                        </div><!--end form-group--> 

                                        <div class="form-group mb-2">
                                            <label class="form-label" >Số điện thoại</label>
                                            <input type="number" class="form-control" id="phone"  placeholder="Nhập số điện thoại">                               
                                        </div><!--end form-group--> 
            
                                        <div class="form-group row mt-3">
                                            <div class="col-12">
                                                <div class="form-check form-switch form-switch-primary">
                                                    <input class="form-check-input" type="checkbox" id="customSwitchPrimary">
                                                    <label class="form-check-label" for="customSwitchPrimary">Đồng ý điều khoản <a href="#" class="text-primary">API SOFTWARE</a></label>
                                                </div>
                                            </div><!--end col--> 
                                        </div><!--end form-group--> 
            
                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <button class="btn btn-primary" type="submit" id="btnRegister">Đăng Ký</button>
                                                </div>
                                            </div>
                                        </div>                          
                                    </form>
                                    <div class="text-center">
                                        <p class="text-muted">Bạn đã có tài khoản ?  <a href="/auth/login" class="text-primary ms-2">Đăng Nhập</a></p>
                                    </div>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end col-->
        </div><!--end row-->                                        
    </div><!-- container -->
    </body>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
<script>
$(document).ready(function() {
    const $btnRegister = $('#btnRegister');
    const btnRegister = async () => {
        try {
            $btnRegister.prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Đang Xử Lý...');
            const username = $('#username').val();
            const email = $('#email').val();
            const password = $('#password').val();
            const confirmpassword = $('#password').val();
            const phone = $('#phone').val();
            const res = await $.ajax({
                url: '/ajax/auth/register',
                type: 'POST',
                dataType: 'json',
                data: { action: 'REGISTER', username, email,password ,confirmpassword,phone},
            });
            if (res.status === 'success') {
                showAlert('Thành công', 'Đăng ký thành công', 'success');
                setTimeout(() => {
                    window.location.href = '/home';
                }, 1500);
            } else {
                showAlert('Thất bại', res.msg, 'error');
            }
        } catch (err) {
            showAlert('Thất bại', 'Lỗi kết nối', 'error');
        } finally {
            $btnRegister.prop('disabled', false).html('Đăng Ký');
        }
    };
    $btnRegister.on('click', btnRegister);
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
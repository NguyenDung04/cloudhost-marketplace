<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <?php
         $slug_name = $_GET['name_server'];
         $sv_host = $ketnoi->get_row("SELECT * FROM `server_hosting` WHERE `to_slug` = '$slug_name' AND `status` = 'on' ");
         if(!$sv_host){
             header("Location: /404");
             exit();
         }
         ?>
      <title>Hosting <?=$sv_host['name_server'];?> | APIIT</title>
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
                        <h4 class="page-title">Hosting <?=$sv_host['name_server'];?></h4>
                        <div class="">
                           <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item">
                                 <a href="/home"><i class="fa-solid fa-house me-1"></i> Trang Chủ</a>
                              </li>
                              <li class="breadcrumb-item active">
                                 <i class="fa-solid fa-server me-1"></i> Hosting <?=$sv_host['name_server'];?>
                              </li>
                           </ol>
                        </div>
                     </div>
                     <!--end page-title-box-->
                  </div>
                  <!--end col-->
               </div>
               <!--end row-->                   
               <div class="row justify-content-center">
                  <?php 
                     foreach($ketnoi->get_list("SELECT * FROM `package_hosting` WHERE `status` = 'on'") as $pk_host):?>  
                  <div class="col-md-6 col-lg-3">
                     <div class="card">
                        <div class="card-body">
                           <div class="text-center">
                              <h6 class="pt-3 pb-2 m-0 fs-18 fw-medium"><?=$pk_host['name_host'];?></h6>
                              <div class="pt-3">
                                 <h1 class="d-inline-block fw-bold"><?=money($pk_host['money']);?>đ</h1>
                                 <small class="font-12 text-muted">/tháng</small>
                              </div>
                              <hr class="hr-dashed">
                              <ul class="list-unstyled pricing-content text-start pt-3 border-0 mb-0">
                                 <li><i class="fa-solid fa-hdd me-2 text-primary"></i> Dung Lượng: <?=money($pk_host['disk']);?> Mb</li>
                                 <li><i class="fa-solid fa-wave-square me-2 text-success"></i> Băng Thông: Không giới hạn</li>
                                 <li><i class="fa-solid fa-shield-halved me-2 text-warning"></i> Miễn Phí Chứng Chỉ SSL</li>
                                 <li><i class="fa-solid fa-globe me-2 text-danger"></i> Miền khác: <?=$pk_host['other_domain'];?></li>
                                 <li><i class="fa-solid fa-layer-group me-2 text-info"></i> Miền bí danh: <?=$pk_host['alias_domain'];?></li>
                              </ul>
                              <a href="/client/hosting-order/<?=$pk_host['id'];?>" class="btn btn-dark py-2 px-5 mt-3 w-100">
                              <span>Mua Ngay</span>
                              </a>
                           </div>
                        </div>
                     </div>
                     <!--end card-->
                  </div>
                  <?php endforeach;?>
                  <!--end col--> 
               </div>
            </div>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
         </div>
      </div>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
   </body>
</html>
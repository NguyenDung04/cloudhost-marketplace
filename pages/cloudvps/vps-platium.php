<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
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
                        <h4 class="page-title">Cloud VPS VN</h4>
                        <div class="">
                           <ol class="breadcrumb mb-0">
                            
                              <li class="breadcrumb-item">
                                 <a href="/home"><i class="fa-solid fa-house me-1"></i> Trang Chủ</a>
                              </li>
                              <li class="breadcrumb-item active">
                                 <i class="fa-solid fa-cloud me-1"></i> Cloud VPS VN
                              </li>
                           </ol>
                        </div>
                     </div>
                  </div>
               </div>              
               <div class="row justify-content-center">
                  <?php foreach($ketnoi->get_list("SELECT * FROM `package_cloudvps` WHERE `status` = 'hoatdong'") as $vps):
                  $price = json_decode($vps['price'], true);
                  $detail = json_decode($vps['detail'], true);
                  ?>
                  <div class="col-md-6 col-lg-3">
                     <div class="card">
                        <div class="card-body">
                           <div class="text-center">
                              <h6 class="pt-3 pb-2 m-0 fs-18 fw-medium"><?=$vps['name'];?></h6>
                              <div class="pt-3">
                                 <h1 class="d-inline-block fw-bold"><?=money($price['monthly']['amount']);?> vnđ</h1>
                                 <small class="font-12 text-muted">/tháng</small>
                              </div>
                              <hr class="hr-dashed">
                              <ul class="list-unstyled pricing-content text-start pt-3 border-0 mb-0">
                                 <li><i class="fa-solid fa-microchip me-2 text-primary"></i> CPU: <?=$detail['cpu'];?> Core Xeon Platinum 8171M</li>
                                 <li><i class="fa-solid fa-memory me-2 text-success"></i> RAM: <?=$detail['ram'];?> GB</li>
                                 <li><i class="fa-solid fa-hard-drive me-2 text-black"></i> DISK: <?=$detail['disk'];?> GB SSD</li>
                                 <li><i class="fa-solid fa-network-wired me-2 text-warning"></i> IP RIÊNG: <?=$detail['ip'];?> IPv4 Riêng IP</li>
                                 <li><i class="fa-solid fa-infinity me-2 text-danger"></i> Băng thông: <?=$detail['bandwidth'];?></li>
                                 <li><i class="fa-solid fa-desktop me-2 text-info"></i> Hệ điều hành: <?=$detail['os'];?></li>
                              </ul>
                              <a href="/client/vps-order/<?=$vps['id'];?>" class="btn btn-dark py-2 px-5 mt-3 w-100"><span>Mua Ngay</span></a>
                           </div>         
                        </div>
                     </div>
                  </div>
                  <?php endforeach;?>
               </div>
            </div>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
         </div>
      </div>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
   </body>
</html>
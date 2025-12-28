<!DOCTYPE html>
<html lang="vi" dir="ltr" data-bs-theme="light">
   <head>
      <meta charset="UTF-8">
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
      <?php
         $slug = antixss($_GET['slug']);
         $check = $ketnoi->get_row("SELECT * FROM `posts` WHERE `slug` = '$slug' AND `status` = 'on'");
         $check_u = $ketnoi->get_row("SELECT * FROM `users` WHERE `username` = '".$check['username']."'");
         $update = $ketnoi->update("posts",array(
            'view' => $check['view'] + 1
         ),"`slug` = '$slug'");
         if(!$check){
           header("Location: /404");
           exit();
         }
         ?>
      <title><?=$check['title'];?> | APIIT</title>
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
                        <h4 class="page-title">Chi tiết bài viết</h4>
                        <div>
                        <ol class="breadcrumb mb-0">
                           <li class="breadcrumb-item">
                              <a href="/home"><i class="fa-solid fa-house me-1"></i> Trang chủ</a>
                           </li>
                           <li class="breadcrumb-item">
                              <a href="/client/blogs"><i class="fa-solid fa-newspaper me-1"></i> Bài viết</a>
                           </li>
                           <li class="breadcrumb-item active">
                              <i class="fa-solid fa-file-lines me-1"></i> Chi tiết bài viết
                           </li>
                        </ol>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <!-- Nội dung chính -->
                  <div class="col-lg-8">
                     <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                           <h4 class="blog-title mb-3"><?=$check['title'];?></h4>
                           <div class="d-flex flex-wrap text-muted small mb-3 align-items-center gap-3">
                              <div><i class="fa-solid fa-user me-1"></i> <?=$check['username'];?></div>
                              <div><i class="fa-regular fa-clock me-1"></i> <?=fmDate($check['time']);?></div>
                              <div><i class="fa-solid fa-eye me-1"></i> <?=money($check['view']);?> lượt xem</div>
                              <div><i class="fa-solid fa-tags me-1"></i><?=type_blog($check['type']);?></div>
                           </div>
                           <div class="content">
                              <?=base64_decode($check['content']);?>
                           </div>
                           <hr>
                           <h6 class="fw-bold mb-2">Chia sẻ bài viết</h6>
                           <?php $link = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
                           <div class="d-flex gap-2 flex-wrap">
                              <button 
                                 class="btn btn-sm btn-primary share-btn" 
                                 onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($link); ?>', '_blank')">
                              <i class="fa-brands fa-facebook-f me-1"></i> Facebook
                              </button>
                              <button 
                                 class="btn btn-sm btn-info text-white share-btn" 
                                 onclick="window.open('https://twitter.com/intent/tweet?url=<?= urlencode($link); ?>&text=<?= urlencode($hot['title'] ?? 'Bài viết hay nè!'); ?>', '_blank')">
                              <i class="fa-brands fa-twitter me-1"></i> Twitter
                              </button>
                              <button 
                                 class="btn btn-sm btn-outline-secondary share-btn" 
                                 onclick="copyLink('<?= $link; ?>')">
                              <i class="fa-solid fa-link me-1"></i> Sao chép liên kết
                              </button>
                           </div>
                           <script>
                              function copyLink(link) {
                                navigator.clipboard.writeText(link).then(() => {
                                  showAlert('Thành công', 'Đã sao chép liên kết bài viết!', 'success');
                                });
                              }
                           </script>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="card mb-4">
                        <div class="card-body text-center">
                           <i class="fa-regular fa-user-circle fa-3x text-primary mb-2"></i>
                           <h6 class="mb-1 fw-semibold"><?=strtoupper($check['username']);?></h6>
                           <small class="text-muted"><?=level($check_u['level']);?></small>
                        </div>
                     </div>
                     <div class="card mb-4">
                        <div class="card-body">
                           <h6 class="fw-bold mb-3"><i class="fa-solid fa-fire text-danger me-2"></i>Bài viết nổi bật</h6>
                           <?php foreach ($ketnoi->get_list("SELECT * FROM `posts` WHERE `status`='on' ORDER BY `view` DESC LIMIT 3") as $hot): ?> 
                           <div class="d-flex align-items-center mb-3">
                              <img src="<?= $hot['image']; ?>" alt="Bài viết nổi bật" width="60" height="45" class="rounded me-2" style="object-fit:cover;">
                              <div>
                                 <a href="/client/view-blog/<?= $hot['slug']; ?>" class="fw-semibold text-dark text-truncate d-block"><?= $hot['title']; ?></a>
                                 <small class="text-muted"><i class="fa-regular fa-clock me-1"></i><?= fmDate($hot['time']); ?></small>
                              </div>
                           </div>
                           <?php endforeach; ?>
                        </div>
                     </div>
                     <div class="card">
                        <div class="card-body">
                           <h6 class="fw-bold mb-3"><i class="fa-solid fa-list text-primary me-2"></i>Danh mục</h6>
                           <ul class="list-unstyled mb-0">
                              <li class="mb-2">
                                 <a href="/client/blogs?type=tin-tuc" class="text-decoration-none d-block">
                                 <i class="fa-solid fa-angles-right text-secondary me-1"></i> Tin Tức
                                 </a>
                              </li>
                              <li>
                                 <a href="/client/blogs?type=huong-dan" class="text-decoration-none d-block">
                                 <i class="fa-solid fa-angles-right text-secondary me-1"></i> Hướng Dẫn
                                 </a>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
         </div>
         <!-- end page-content -->
      </div>
      <!-- end page-wrapper -->
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
   </body>
</html>
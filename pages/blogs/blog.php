<!DOCTYPE html>
<html lang="vi">
   <head>
      <meta charset="UTF-8">
      <title>Tin tức & Blog | APIIT</title>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php'; ?>
      <style>
         .blog-card {
         transition: 0.3s ease;
         border: 1px solid #eee;
         border-radius: 10px;
         }
         .blog-card:hover {
         transform: translateY(-3px);
         box-shadow: 0 5px 15px rgba(0,0,0,0.08);
         }
         .blog-thumb {
         width: 100%;
         height: 180px;
         object-fit: cover;
         border-radius: 8px;
         }
         .sidebar-box {
         border: 1px solid #eee;
         border-radius: 10px;
         padding: 15px;
         background: #fff;
         }
         .sidebar-box h6 {
         font-weight: 600;
         border-bottom: 1px dashed #ddd;
         padding-bottom: 6px;
         margin-bottom: 10px;
         }
      </style>
   </head>
   <body>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/nav.php'; ?>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/sidebar.php'; ?>
      <div class="page-wrapper">
         <div class="page-content">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Bài viết</h4>
                        <div class="">
                           <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item">
                                 <a href="/home"><i class="fa-solid fa-house me-1"></i> Trang chủ</a>
                              </li>
                              <li class="breadcrumb-item active">
                                 <i class="fa-solid fa-pen-to-square me-1"></i></i> Bài viết
                              </li>
                           </ol>
                        </div>
                     </div>
                     <!--end page-title-box-->
                  </div>
                  <!--end col-->
               </div>
               <div class="row">
                  <div class="col-lg-8 mb-4">
                     <div class="card p-3 border-0 shadow-sm mb-4">
                        <form method="GET" class="row g-3">
                           <div class="col-md-6">
                              <label class="form-label fw-semibold">Từ khóa tìm kiếm</label>
                              <input type="text" name="q" class="form-control" placeholder="Nhập từ khóa..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                           </div>
                           <div class="col-md-4">
                              <label class="form-label fw-semibold">Danh mục</label>
                              <select name="type" class="form-select">
                                 <option value="">Tất cả danh mục</option>
                                 <?php
                                    $categories = [
                                        'tin-tuc' => 'Tin Tức',
                                        'huong-dan' => 'Hướng Dẫn'
                                    ];
                                    $current = $_GET['type'] ?? '';
                                    foreach ($categories as $key => $label) {
                                        $selected = ($current === $key) ? 'selected' : '';
                                        echo "<option value='$key' $selected>$label</option>";
                                    }
                                    ?>
                              </select>
                           </div>
                           <div class="col-md-2 d-flex align-items-end">
                              <button class="btn btn-primary w-100" type="submit"><i class="fa-solid fa-search me-1"></i> Tìm kiếm</button>
                           </div>
                        </form>
                     </div>
                     <div class="row">
                        <?php
                           $q = isset($_GET['q']) ? trim($_GET['q']) : '';
                           $type = isset($_GET['type']) ? trim($_GET['type']) : '';
                           if(isset($_GET['q']) && $_GET['q'] != ''){
                               $posts = $ketnoi->get_list("SELECT * FROM `posts` WHERE `status`='on' AND (`title` LIKE '%$q%' OR `content` LIKE '%$q%' OR `username` LIKE '%$q%') ORDER BY `id` DESC");
                           }elseif(isset($_GET['type']) && $_GET['type'] != ''){
                               $posts = $ketnoi->get_list("SELECT * FROM `posts` WHERE `status`='on' AND `type` = '$type' ORDER BY `id` DESC");
                           }else{
                               $posts = $ketnoi->get_list("SELECT * FROM `posts` WHERE `status`='on' ORDER BY `id` DESC");
                           }
                           if (empty($posts)) {
                               echo '
                               <div class="col-12 text-center py-5">
                                   <i class="fa-regular fa-newspaper fa-3x text-secondary mb-3"></i>
                                   <h6 class="text-muted mb-0">Không có bài viết nào được tìm thấy!</h6>
                                   <p class="text-muted small mt-1">Hãy thử tìm kiếm với từ khóa khác hoặc chọn danh mục khác.</p>
                               </div>';
                           } else {
                               foreach ($posts as $post): ?>
                        <div class="col-md-4 mb-4">
                           <a href="/client/view-blog/<?= $post['slug']; ?> ">
                              <div class="p-3 blog-card bg-white shadow-sm h-100">
                                 <img src="<?= $post['image']; ?>" class="blog-thumb mb-3" alt="<?= htmlspecialchars($post['title']); ?>">
                                 <h6 class="fw-bold text-dark text-truncate"><?= $post['title']; ?></h6>
                                 <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">
                                       <i class="fa-regular fa-clock me-1"></i> <?= fmDate($post['time']); ?> |
                                       <i class="fa-solid fa-eye ms-1 me-1"></i> <?= number_format($post['view']); ?> lượt xem
                                    </div>
                                 </div>
                              </div>
                           </a>
                        </div>
                        <?php endforeach;
                           } ?>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="sidebar-box mb-4">
                        <h6><i class="fa-solid fa-list me-2"></i>Danh mục</h6>
                        <ul class="list-unstyled mb-0">
                           <?php
                              $categories = [
                                  'tin-tuc' => 'Tin Tức',
                                  'huong-dan' => 'Hướng Dẫn'
                              ];
                              $currentType = $_GET['type'] ?? '';
                              ?>
                           <ul class="list-unstyled mb-0">
                              <?php foreach ($categories as $key => $label): 
                                 $active = ($currentType === $key) ? 'fw-bold text-primary' : 'text-dark'; ?>
                              <li class="mb-2">
                                 <a href="?type=<?= $key; ?>" class="text-decoration-none <?= $active; ?>">
                                 <i class="fa-solid fa-angles-right me-1"></i> <?= $label; ?>
                                 </a>
                              </li>
                              <?php endforeach; ?>
                           </ul>
                        </ul>
                     </div>
                     <div class="sidebar-box">
                        <h6><i class="fa-solid fa-fire me-2"></i>Bài viết nổi bật</h6>
                        <?php
                           $hotPosts = $ketnoi->get_list("SELECT * FROM `posts` WHERE `status`='on' ORDER BY `view` DESC LIMIT 3");
                           foreach ($hotPosts as $hot): ?>
                        <a href="/client/view-blog/<?= $hot['slug']; ?> ">
                           <div class="d-flex align-items-center mb-3">
                              <img src="<?= $hot['image']; ?>" class="rounded me-2" width="60" height="45" style="object-fit:cover;">
                              <div>
                        <a href="/client/view-blog/<?= $hot['slug']; ?>" class="text-dark fw-semibold d-block text-truncate"><?= $hot['title']; ?></a>
                        <small class="text-muted"><i class="fa-regular fa-clock me-1"></i><?= fmDate($hot['time']); ?></small>
                        </div>
                        </div>
                        </a>
                        <?php endforeach; ?>
                     </div>
                  </div>
               </div>
            </div>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php'; ?>
         </div>
      </div>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php'; ?>
   </body>
</html>
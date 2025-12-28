<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
<head>
  <title>Danh sách đơn đặt hàng | APIIT</title>
  <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
  <style>
    .pagination li {
      cursor: pointer;
    }
    .table td, .table th {
      vertical-align: middle !important;
      text-align: center;
    }
  </style>
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
              <h4 class="page-title">Danh sách đơn đặt hàng</h4>
              <div class="">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="/home"><i class="fa-solid fa-house me-1"></i> Trang chủ</a></li>
                  <li class="breadcrumb-item active"><i class="fa-solid fa-cart-shopping me-1"></i> Đơn đặt hàng</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Danh sách đơn đặt hàng</h4>
            <button class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tạo VPS</button>
          </div>

          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-6 d-flex align-items-center">
                <label class="me-2">
                  <select id="entriesPerPage" class="form-select form-select-sm w-auto">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select>
                </label>
                <span>dòng mỗi trang</span>
              </div>
              <div class="col-md-6 text-end">
                <input type="text" id="searchInput" class="form-control form-control-sm d-inline-block w-auto" placeholder="Tìm kiếm...">
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped mb-0">
                <thead class="table-light">
                  <tr>
                    <th>ID</th>
                    <th>Ngày Đặt Hàng</th>
                    <th>Số lượng</th>
                    <th>Tổng Tiền Thanh Toán</th>
                    <th>Chu Kỳ Thanh Toán</th>
                    <th>Trạng Thái</th>
                    
                  </tr>
                </thead>
                <tbody id="ordersData">
                  <tr><td colspan="6">Đang tải dữ liệu...</td></tr>
                </tbody>
              </table>
            </div>
            <div class="row mt-2">
              <div class="col-md-6">
                <small id="tableInfo">Hiển thị 0 tới 0 của 0 dòng</small>
              </div>
              <div class="col-md-6">
                <ul class="pagination pagination-sm justify-content-end mb-0" id="pagination"></ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
    </div>
  </div>
  <?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>

  <script>
  $(document).ready(function () {
    let currentPage = 1;
    function showLoading() {
      $('#ordersData').html(`
        <tr>
          <td colspan="6" class="text-center py-4">
            <img src="/core/upload/images/loading.gif" width="42" alt="Loading...">
            <p class="mt-2 text-muted small">Đang tải dữ liệu...</p>
          </td>
        </tr>
      `);
    }
    function loadOrders(page = 1) {
      const limit = $('#entriesPerPage').val();
      const search = $('#searchInput').val();
      $.ajax({
        url: '/ajax/orders/order.php',
        method: 'POST',
        data: { page, limit, search },
        dataType: 'json',
        beforeSend: function () {
          showLoading();
        },
        success: function (res) {
          if (res.error) {
            $('#ordersData').html(`
              <tr><td colspan="6" class="text-danger text-center py-3">${res.message}</td></tr>
            `);
            $('#pagination').html('');
            $('#tableInfo').text('');
            return;
          }
          let html = '';
          if (!res.data || res.data.length === 0) {
            html = `
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">
                  <i class="fa-regular fa-folder-open fa-2x mb-2"></i><br>Không có dữ liệu
                </td>
              </tr>
            `;
          } else {
            let stt = res.from;
            res.data.forEach(o => {
              html += `
                <tr>
                  <td><a href="#">#${stt++}</a></td>
                  <td>${o.date}</td>
                  <td class="text-danger">${o.quantity}</td>
                  <td>${o.total}</td>
                  <td>${o.cycle}</td>
                  <td>${o.status}</td>
                  
                </tr>`;
            });
          }
          $('#ordersData').html(html);
          $('#tableInfo').text('Hiển thị ' + res.from + ' tới ' + res.to + ' của ' + res.total + ' dòng');
          let paginationHTML = '';
          paginationHTML += `
            <li class="page-item ${page === 1 ? 'disabled' : ''}">
              <a class="page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
          `;
          const maxPages = 5; 
          const startPage = Math.max(1, page - 2);
          const endPage = Math.min(res.pages, startPage + maxPages - 1);
          for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `
              <li class="page-item ${i === page ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
              </li>
            `;
          }
          paginationHTML += `
            <li class="page-item ${page >= res.pages ? 'disabled' : ''}">
              <a class="page-link" href="#" data-page="${page + 1}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          `;
          $('#pagination').html(paginationHTML);
        },
        error: function () {
          $('#ordersData').html(`
            <tr><td colspan="6" class="text-danger text-center py-3">Không thể tải dữ liệu từ máy chủ</td></tr>
          `);
        },
      });
    }
    $('#entriesPerPage').on('change', function () {
      currentPage = 1;
      loadOrders(currentPage);
    });
    $('#searchInput').on('keyup', function () {
      currentPage = 1;
      loadOrders(currentPage);
    });
    $('#pagination').on('click', 'a', function (e) {
      e.preventDefault();
      const page = parseInt($(this).data('page'));
      if (!isNaN(page) && page > 0) {
        currentPage = page;
        loadOrders(currentPage);
      }
    });
    loadOrders();
  });
</script>
</body>
</html>
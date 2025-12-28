<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
<head>
    <title>Quản lý hóa đơn | APIIT</title>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
    <style>
        .pagination li { cursor: pointer; }
        .table td, .table th { vertical-align: middle !important; text-align: center; }
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
                        <h4 class="page-title">Quản lý hóa đơn</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/home"><i class="fa-solid fa-house me-1"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item active"><i class="fa-solid fa-file-invoice-dollar me-1"></i> Hóa đơn</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- Table Card -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Quản lý hóa đơn</h4>
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
                                            <th>#</th>
                                            <th>Loại</th>
                                            <th>Hóa đơn ngày</th>
                                            <th>Ngày thanh toán</th>
                                            <th>Tổng tiền thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="billsData">
                                        <tr>
                                            <td colspan="6">Đang tải dữ liệu...</td>
                                        </tr>
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
        $('#billsData').html(`
            <tr>
                <td colspan="6" class="text-center py-4">
                    <img src="/core/upload/images/loading.gif" width="42" alt="Loading...">
                    <p class="mt-2 text-muted small">Đang tải dữ liệu...</p>
                </td>
            </tr>
        `);
    }
    function loadBills(page = 1) {
        const limit = $('#entriesPerPage').val();
        const search = $('#searchInput').val();

        $.ajax({
            url: '/ajax/orders/bill.php',
            method: 'POST',
            data: { page, limit, search },
            dataType: 'json',
            beforeSend: showLoading,
            success: function(res) {
                let html = '';
                if(res.error) {
                    html = `<tr><td colspan="6" class="text-danger text-center py-3">${res.message}</td></tr>`;
                    $('#pagination').html('');
                    $('#tableInfo').text('');
                } else if(!res.data || res.data.length === 0 || res.data.error === true) {
                    html = `<tr><td colspan="6" class="text-center py-4 text-muted">
                        <i class="fa-regular fa-folder-open fa-2x mb-2"></i><br>Không có dữ liệu
                    </td></tr>`;
                } else {
                    let stt = res.from;
                    res.data.forEach(o => {
                        html += `<tr>
                            <td><a href="#">#${stt++}</a></td>
                            <td>${o.title}</td>
                            <td>${o.time}</td>
                            <td>${o.order_date}</td>
                            <td>${o.order_money}</td>
                            <td>${o.status}</td>
                            <td>
                                <a href="/client/invoice/${o.id}" class="btn btn-sm btn-primary">Chi tiết</a>
                            </td>
                        </tr>`;
                    });
                }
                $('#billsData').html(html);
                $('#tableInfo').text(`Hiển thị ${res.from} tới ${res.to} của ${res.total} hóa đơn`);
                let paginationHTML = '';
                paginationHTML += `<li class="page-item ${page === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${page-1}">&laquo;</a>
                </li>`;
                const maxPages = 5;
                const startPage = Math.max(1, page-2);
                const endPage = Math.min(res.pages, startPage + maxPages -1);
                for(let i=startPage;i<=endPage;i++){
                    paginationHTML += `<li class="page-item ${i===page?'active':''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>`;
                }
                paginationHTML += `<li class="page-item ${page>=res.pages?'disabled':''}">
                    <a class="page-link" href="#" data-page="${page+1}">&raquo;</a>
                </li>`;
                $('#pagination').html(paginationHTML);
            },
            error: function() {
                $('#billsData').html(`<tr><td colspan="6" class="text-danger text-center py-3">Không thể tải dữ liệu từ máy chủ</td></tr>`);
            }
        });
    }
    $('#entriesPerPage').on('change', function(){ currentPage=1; loadBills(currentPage); });
    $('#searchInput').on('keyup', function(){ currentPage=1; loadBills(currentPage); });
    $('#pagination').on('click','a', function(e){
        e.preventDefault();
        const page = parseInt($(this).data('page'));
        if(!isNaN(page) && page>0){ currentPage=page; loadBills(currentPage); }
    });
    loadBills();
});
</script>
</body>
</html>
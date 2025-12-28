<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';

if (!checkUser($username, $session)) {
    echo json_encode([
        'error' => true,
        'message' => 'Bạn không có quyền thực hiện hành động này'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
try {
    $page   = max(1, (int)antixss($_POST['page'] ?? 1));
    $limit  = max(1, (int)antixss($_POST['limit'] ?? 10));
    $search = trim(antixss($_POST['search'] ?? ''));
    $offset = ($page - 1) * $limit;
    $where = "`username` = '$username'";
    if ($search !== '') {
        $safeSearch = addslashes($search);
        $where .= " AND (
            `id` LIKE '%$safeSearch%' OR
            `billing_cycle` LIKE '%$safeSearch%' OR
            `status` LIKE '%$safeSearch%' OR
            `total_money` LIKE '%$safeSearch%' OR
            `created_at` LIKE '%$safeSearch%'
        )";
    }
    $total = $ketnoi->num_rows("SELECT * FROM `orders` WHERE $where");
    $pages = ceil($total / $limit);
    $orders = $ketnoi->get_list("SELECT * FROM `orders` WHERE $where ORDER BY `id` DESC LIMIT $offset, $limit");
    $data = [];
    foreach ($orders as $order) {
        $data[] = [
            'id'       => (int)$order['id'],
            'date'     => fmDate($order['created_at']),
            'quantity' => (int)$order['quantity'],
            'total'    => money(($order['total_money'] ?? 0), 0, ',', '.') . 'đ',
            'cycle'    => check_Month($order['billing_cycle']),
            'status'   => status($order['status']) 
        ];
    }
    echo json_encode([
        'error' => false,
        'page'  => $page,
        'limit' => $limit,
        'total' => $total,
        'pages' => $pages,
        'from'  => ($offset + 1),
        'to'    => min($offset + $limit, $total),
        'data'  => $data
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Throwable $e) {
    echo json_encode([
        'error' => true,
        'message' => 'Lỗi truy vấn: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
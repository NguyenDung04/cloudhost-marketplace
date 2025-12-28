<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
header('Content-Type: application/json; charset=utf-8');

if (!checkUser($username, $session)) {
    echo json_encode([
        'error' => true,
        'message' => 'Bạn không có quyền thực hiện hành động này'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
try {
    $page   = max(1, (int)($_POST['page'] ?? 1));
    $limit  = max(1, (int)($_POST['limit'] ?? 10));
    $search = trim($_POST['search'] ?? '');
    $offset = ($page - 1) * $limit;

    $where = "i.username = '$username'";
    if ($search !== '') {
        $safeSearch = addslashes($search);
        $where .= " AND (
            i.id LIKE '%$safeSearch%' OR
            i.title LIKE '%$safeSearch%' OR
            i.time LIKE '%$safeSearch%' OR
            i.id_oder LIKE '%$safeSearch%'
        )";
    }
    $total = $ketnoi->num_rows("SELECT * FROM invoices i WHERE $where");
    $sql = "
        SELECT 
            i.*, 
            o.total_money AS order_money,
            o.status AS status,
            o.created_at AS order_created
        FROM invoices i
        LEFT JOIN orders o 
            ON o.code = i.id_oder 
            AND o.id = (
                SELECT MAX(id) FROM orders WHERE code = i.id_oder
            )
        WHERE $where
        ORDER BY i.id DESC
        LIMIT $offset, $limit
    ";
    $invoices = $ketnoi->get_list($sql);
    $data = [];
    foreach ($invoices as $invoice) {
        $data[] = [
            'id'           => (int)$invoice['id'],
            'id_oder'      => $invoice['id_oder'],
            'title'        => $invoice['title'],
            'time'         => fmDate($invoice['time']),
            'order_date'   => fmDate($invoice['order_created']),
            'order_money'  => money($invoice['order_money']).'đ',
            'status'       => status($invoice['status']),
        ];
    }
    echo json_encode([
        'error' => false,
        'page'  => $page,
        'limit' => $limit,
        'total' => $total,
        'pages' => ceil($total / $limit),
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
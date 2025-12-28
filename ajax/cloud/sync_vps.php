<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/cloud-vps.php';

$data = json_decode(file_get_contents('php://input'), true);
$vps_ids = $data['ids'] ?? [];
if (empty($vps_ids)) {
    echo json_encode(['success' => false, 'message' => 'Không có ID VPS']);
    exit;
}
$count = syncVpsList($vps_ids);
$list = [];
foreach ($vps_ids as $id) {
    $row = $ketnoi->get_row("SELECT id_vps, data, status FROM `purchased_cloudvps` WHERE `id_vps` = '$id'");
    if ($row) {
        $info = json_decode($row['data'], true) ?? [];
        $list[] = [
            'vps-id' => $row['id_vps'],
            'ip' => $info['ip'] ?? '',
            'username' => $info['username'] ?? '',
            'status' => $row['status'],
            'html-status' => status_vps($row['status'])
        ];
    }
}
echo json_encode([
    'success' => true,
    'updated' => $count,
    'data' => $list
], JSON_UNESCAPED_UNICODE);
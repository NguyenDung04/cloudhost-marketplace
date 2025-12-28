<?php 
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
// require $_SERVER['DOCUMENT_ROOT'].'/core/cloud-vps.php';

$token = get_token();
$data = getListVps();
$json = is_array($data) ? $data : json_decode($data, true);

if (!isset($json['list-service']) || !is_array($json['list-service'])) {
    exit(json_encode(['error' => 1, 'message' => 'Không có dữ liệu VPS hợp lệ']));
}

$now = date('Y-m-d H:i:s');
$list = [];
$updated = 0;

foreach ($json['list-service'] as $vps) {
    $vps_id = $vps['vps-id'] ?? null;
    if (empty($vps_id)) continue;
    $info = [
        'vps-id' => $vps_id,
        'cpu' => $vps['cpu'] ?? null,
        'ram' => $vps['ram'] ?? null,
        'disk' => $vps['disk'] ?? null,
        'text-config' => $vps['text-config'] ?? '',
        'day-left' => $vps['day-left'] ?? '',
    ];
    $status_api = $vps['vps-status'] ?? 'unknown';
    $old = $ketnoi->get_row("SELECT data, status FROM `purchased_cloudvps` WHERE `id_vps` = '$vps_id'");
    $need_update = false;

    if ($old) {
        $old_data = json_decode($old['data'], true) ?? [];
        $hash_new = md5(json_encode($info));
        $hash_old = md5(json_encode($old_data));
        if ($hash_new !== $hash_old || $old['status'] !== $status_api) {
            $need_update = true;
        }
    } else {
        $need_update = true;
    }

    if ($need_update) {
        $updated++;
        $ketnoi->update("purchased_cloudvps", [
            'data' => json_encode($info, JSON_UNESCAPED_UNICODE),
            'billingcycleday' => $vps['day-left'] ?? '',
            'status' => $status_api,
            'updated_at' => $now
        ], "`id_vps` = '".$vps_id."'");
    }

    $list[] = $info;
}

$result = [
    'error' => 0,
    'message' => 'Đã cập nhật dữ liệu VPS thành công',
    'total' => count($list),
    'updated' => $updated,
    'list-service' => $list
];

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
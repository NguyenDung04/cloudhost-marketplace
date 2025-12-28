<?php 
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $listvps = $ketnoi->get_list("SELECT * FROM `package_cloudvps` WHERE `status` = 'hoatdong'");
    $vpsData = [];
    foreach ($listvps as $row) {
        $price = json_decode($row['price'], true);
        $detail = json_decode($row['detail'], true);
        $vpsData[] = [
            'id'    => $row['id'],
            'name'  => $row['name'],
            'cpu'   => $detail['cpu'] ?? null,
            'ram'   => $detail['ram'] ?? null,
            'disk'  => $detail['disk'] ?? null + "Mb",
            'price' => money($price['monthly']['amount']) ?? 0 ,
            'url'   => 'https://localhost/client/vps-order/'.$row['id'],
        ];
    }
    $listhosting = $ketnoi->get_list("SELECT * FROM `package_hosting` WHERE `status` = 'on'");
    $hostingData = [];
    foreach ($listhosting as $row) {
        $hostingData[] = [
            'id'          => $row['id'],
            'name'        => $row['name_host'],
            'money'       => money($row['money']),
            'disk'        => money($row['disk']),
            'url'        => "https://localhost/client/hosting-order/".$row['id'],
        ];
    }
    echo json_encode([
        'status' => 'success',
        'data' => [
            'cloud_vps'  => $vpsData,
            'hosting'    => $hostingData
        ]
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
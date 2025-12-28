<?php 
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/cloud-vps.php';

$token = getToken();
$data = getProduct();
if (!empty($data['products']['vps'][0]['product'])) {
    foreach ($data['products']['vps'][0]['product'] as $key => $product) {
        if ($key === 'limit-os') continue;
        $check = $ketnoi->get_row("SELECT * FROM `package_cloudvps` WHERE `product_id` = '".$product['product_id']."'");
        if($check){
            $ketnoi->update("package_cloudvps", [
                'detail'     => json_encode($product, JSON_UNESCAPED_UNICODE),
                'pricing'    => json_encode($product['pricing'], JSON_UNESCAPED_UNICODE),
                'price'      => json_encode($product['pricing'], JSON_UNESCAPED_UNICODE),
                'updated_at' => $now,
            ], "`id` = '".$check['id']."'");
        }else{
            $ketnoi->insert("package_cloudvps", [
                'product_id' => $product['product_id'],
                'name'       => $product['name'],
                'detail'     => json_encode($product, JSON_UNESCAPED_UNICODE),
                'pricing'    => json_encode($product['pricing'], JSON_UNESCAPED_UNICODE),
                'price'      => json_encode($product['pricing'], JSON_UNESCAPED_UNICODE),
                'status'     => 'hoatdong',
                'created_at' => $now,
                'updated_at' => $now,
                'site'       => 'VNCLOUD'
            ]);
        }
    }
} else {
    echo "Không có dữ liệu VPS hợp lệ.";
}
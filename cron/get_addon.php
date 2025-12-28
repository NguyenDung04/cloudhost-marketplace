<?php 
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/cloud-vps.php';
$token = getToken();
$data  = getProduct();
if (!empty($data['products']['addon_vps'][0]['product'])) {
    foreach ($data['products']['addon_vps'][0]['product'] as $product) {
        $check = $ketnoi->get_row("SELECT * FROM `addon_vps` WHERE `product_id` = '".$product['product_id']."'");
        if ($check) {
            $ketnoi->update("addon_vps", [
                'detail'     => json_encode($product, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                'price'      => json_encode($product['pricing'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                'updated_at' => $now
            ], "`id` = '".$check['id']."'");
        } else {
            $ketnoi->insert("addon_vps", [
                'product_id' => $product['product_id'],
                'name'       => $product['name'],
                'type_addon' => $product['type_addon'],
                'detail'     => json_encode($product),
                'price'      => json_encode($product),
                'created_at' => $now,
                'updated_at' => $now,
                'site'       => 'VNCLOUD'
            ]);
        }
    }
} else {
    echo "Không có dữ liệu Addon VPS hợp lệ.";
}
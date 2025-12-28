<?php 
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/cloud-vps.php';
$token = getToken();
$data  = getListOs();
if (!empty($data['os-vps'])) {
    foreach ($data['os-vps'] as $os) {
        $check = $ketnoi->get_row("SELECT * FROM `img_os` WHERE `os_name` = '".$os['os-name']."'");
        if ($check) {
            $ketnoi->update("img_os", [
                'os_name'    => $os['os-name'],
                'id_os' => $os['os-id'],
                'updated_at' => $now
            ], "`id` = '".$check['id']."'");
        } else {
            $ketnoi->insert("img_os", [
                'id_os'      => $os['os-id'],
                'os_name'    => $os['os-name'],
                'image_url'  => 'Null',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
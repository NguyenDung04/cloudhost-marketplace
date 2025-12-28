<?php
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'LOAD_PRICE') {
        $id_host = antixss($_POST['id_host']);
        $month = antixss($_POST['month']);
        $discount = antixss($_POST['discount']);
        $check = $ketnoi->get_row("SELECT * FROM `package_hosting` WHERE `id` = '$id_host' AND `status` = 'on'");
        if (!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif($id_host == "" || $month == "" || $discount == ""){
            json_Msg('error','Thiếu thông tin');
        }elseif(!$check){
            json_Msg('error','Hosting không tồn tại');
        }else{
            $price = $check['money'] * $month ;
            if ($month == 12) {
                $price -= $price * 0.1;
            } elseif ($month == 24) {
                $price -= $price * 0.2;
            } elseif ($month == 60) {
                $price -= $price * 0.4;
            }
            $total_money = checkDiscount($price, $discount);
            exit(json_encode([
                'status' => 'success',
                'amount_raw' => $total_money,
                'price' => money($total_money)
            ]));
        }
    }elseif(isset($_POST['action']) && $_POST['action'] == 'DISCOUNT'){
        $discount = antixss($_POST['discount']);
        $check_dis = checkDisCode($discount);
        if($check_dis['status'] == 'success'){
            exit(json_encode([
                'status' => 'success',
                'discount' => $check_dis['discount'],
                'price' => $check_dis['price']
            ]));
        }
    }
}
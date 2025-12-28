<?php 
require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'LOAD_PRICE') {
        $months = antixss($_POST['billingcycle']);         
        $id_vps = antixss($_POST['vpsid']);
        $cpu = antixss($_POST['cpu']);
        $ram = antixss($_POST['ram']);
        $disk = antixss($_POST['disk']);
        $os = antixss($_POST['os']);
        $diskcost = antixss($_POST['discount']);
        $check_vps = $ketnoi->get_row("SELECT * FROM `package_cloudvps` WHERE `id` = '$id_vps' AND `status` = 'hoatdong'");
        $check_addon = $ketnoi->get_row("SELECT * FROM `addon_vps`");
        $price_json = $check_vps['price'] ?? '';
        $prices = json_decode($price_json, true);
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif(!$check_vps){
            json_Msg('error','Vps không tồn tại');
        }elseif($months == ""){
            json_Msg('error','Vui lòng chọn chu kỳ thanh toán');
        }elseif($cpu == "" || $ram == "" || $disk == ""){
            json_Msg('error','Vui lòng chọn CPU, RAM, Disk');
        }elseif (!ctype_digit((string)$cpu) || !ctype_digit((string)$ram) || $cpu < 0 || $cpu > 10 || $ram < 0 || $ram > 10) {
            json_Msg('error', 'CPU, RAM phải là số nguyên từ 0 đến 10');
        }elseif ($disk && (!ctype_digit((string)$disk) || $disk < 10 || $disk > 100 || $disk % 10 != 0)) {
            json_Msg('error', 'Addon DISK phải là số nguyên chia hết cho 10 và nhỏ hơn hoặc bằng 100');
        }elseif (!$prices || !is_array($prices)) {
            json_Msg('error', 'Dữ liệu giá không hợp lệ');
        }else{
            $total_disk = getPriceAddon('addon_disk',$disk , $months) ?? 0;
            $total_cpu = getPriceAddon('addon_cpu',$cpu , $months) ?? 0;
            $total_ram = getPriceAddon('addon_ram',$ram , $months) ?? 0;
            $amount = (float)$prices[$months]['amount'];
            $subtotal = $amount + $total_disk + $total_cpu + $total_ram;
            $total_money = checkDiscount($subtotal, $diskcost);
            exit(json_encode([
                'status'     => 'success',
                'amount_raw' => $total_money,
                'price'      => money($total_money)
            ]));
        }
    }elseif(isset($_POST['action']) && $_POST['action'] == 'DISCOUNT'){
        $discount = antixss($_POST['discount']);
        $check_dis = checkDisCode($discount);
        if($check_dis['status'] == 'success'){
            exit(json_encode([
                'status'     => 'success',
                'discount' => $check_dis['discount'],
                'price'      => $check_dis['price']
            ]));
        }
    }
}
?>
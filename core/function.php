<?php
function api_card($telco, $amount, $serial, $pin, $trans_id){
    global $ketnoi;
    $partner_id  = $ketnoi->site('partner_id_card');
    $partner_key = $ketnoi->site('partner_key_card');
    $url_api = $ketnoi->site('api_card');
    $sign = md5($partner_key . $pin . $serial);
    $data = [
        'telco'      => $telco,
        'code'       => $pin,
        'serial'     => $serial,
        'amount'     => $amount,
        'request_id' => $trans_id,
        'partner_id' => $partner_id,
        'sign'       => $sign,
        'command'    => 'charging'
    ];
    $ch = curl_init($url_api .'/chargingws/v2');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}
function timeDifference($start, $end) {
    $diff = $end - $start;
    if ($diff < 0) {
        return "Thời gian kết thúc nhỏ hơn thời gian bắt đầu!";
    }
    $days = floor($diff / (60 * 60 * 24));
    return $days;
}
function checkCycle($cycle) {
    $map = [
        1  => 'monthly',
        2  => 'twomonthly',
        3  => 'quarterly',
        6  => 'semi_annually',
        12 => 'annually',
        24 => 'biennially',
        36 => 'triennially'
    ];
    if (isset($map[$cycle])) {
        return $map[$cycle];
    }
    $cycles = [
        'monthly'        => ['months' => 1,  'label' => '1 Tháng'],
        'twomonthly'     => ['months' => 2,  'label' => '2 Tháng'],
        'quarterly'      => ['months' => 3,  'label' => '3 Tháng'],
        'semi_annually'  => ['months' => 6,  'label' => '6 Tháng'],
        'annually'       => ['months' => 12, 'label' => '1 Năm'],
        'biennially'     => ['months' => 24, 'label' => '2 Năm'],
        'triennially'    => ['months' => 36, 'label' => '3 Năm'],
    ];
    return $cycles[$cycle] ?? false;
}
function type_blog($data){
    $status = array(
        "tin-tuc" => 'Tin Tức',
        "huong-dan" => 'Hướng Dẫn',
        "khuyen-mai" => 'Khuyến Mãi',
    );
    if (array_key_exists($data, $status)) {
        return $status[$data];
    } else {
        return 'Chưa Xác Định';
    }
}
function checkUser($username , $session){
    global $user , $ketnoi;
    $check = $ketnoi->get_row("SELECT * FROM `users` WHERE `username` = '$username' AND `session_token` = '$session'");
    if($check){
        return true;
    }else{
        return false;
    }
}
function getPriceAddon($type,$quantity,$billingcycle){
    global $ketnoi;
    if($quantity > 0){
        $check = $ketnoi->get_row("SELECT * FROM `addon_vps` WHERE `type_addon` = '$type'");
        $detail = json_decode($check['price'], true);
        $price = $detail['pricing'][$billingcycle]['amount'] * $quantity;
        return $price;
    }
}
function check_Month($data){
    $status = array(
        "monthly" => '1 Tháng',
        "huong-dan" => 'Hướng Dẫn',
        "khuyen-mai" => 'Khuyến Mãi',
    );
    if (array_key_exists($data, $status)) {
        return $status[$data];
    } else {
        return 'Chưa Xác Định';
    }
}
function status_vps($data){
    $status = array(
       "progressing" => '<span class="badge bg-warning-subtle text-warning"><i class="fa-solid fa-spinner fa-spin me-1"></i>Đang khởi tạo</span>',
        "active"      => '<span class="badge bg-success-subtle text-success"><i class="fa-solid fa-play me-1"></i>Đang hoạt động</span>',
        "on"          => '<span class="badge bg-success-subtle text-success"><i class="fa-solid fa-circle-play me-1"></i>Đang bật</span>',
        "off"         => '<span class="badge bg-secondary-subtle text-secondary"><i class="fa-solid fa-power-off me-1"></i>Đã tắt</span>',
        "delete_vps"  => '<span class="badge bg-danger-subtle text-danger"><i class="fa-solid fa-trash me-1"></i>Đã xóa</span>',
        "expired"     => '<span class="badge bg-danger-subtle text-danger"><i class="fa-solid fa-clock me-1"></i>Đã hết hạn</span>',
        "suspended"   => '<span class="badge bg-dark-subtle text-dark"><i class="fa-solid fa-lock me-1"></i>Bị tạm khóa</span>',
        "pending"     => '<span class="badge bg-info-subtle text-info"><i class="fa-solid fa-hourglass-half me-1"></i>Đang chờ xử lý</span>',
        "error"       => '<span class="badge bg-danger-subtle text-danger"><i class="fa-solid fa-circle-exclamation me-1"></i>Lỗi hệ thống</span>',
        "cancel"   => '<span class="badge bg-dark-subtle text-dark"><i class="fa-solid fa-ban me-1"></i>Đã hủy</span>',
        "renewing"    => '<span class="badge bg-primary-subtle text-primary"><i class="fa-solid fa-rotate me-1"></i>Đang gia hạn</span>',
        "rebuild" => '<span class="badge bg-info-subtle text-info"><i class="fa-solid fa-rotate-right me-1"></i>Đang cài đặt lại</span>',
        
    );
    if (array_key_exists($data, $status)) {
        return $status[$data];
    } else {
        return 'Chưa Xác Định';
    }
}
function loadPrice($postData){
    global $ketnoi , $username;
    $months   = antixss($postData['billingcycle']);
    $id_vps   = antixss($postData['vpsid']);
    $cpu      = antixss($postData['cpu']);
    $ram      = antixss($postData['ram']);
    $disk     = antixss($postData['disk']);
    $os       = antixss($postData['os']);
    $discount = antixss($postData['discount']);
    $check_vps = $ketnoi->get_row("SELECT * FROM `package_cloudvps` WHERE `product_id` = '$id_vps' AND `status` = 'hoatdong'");
    $check_addon = $ketnoi->get_row("SELECT * FROM `addon_vps`");
    $price_json = $check_vps['price'] ?? '';
    $prices = json_decode($price_json, true);
    if($username == ""){
        json_Msg('error','Vui lòng đăng nhập');
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
        $total_money = checkDiscount($subtotal, $discount);
        return [
            'status' => '1',
            'product_id' => $check_vps['product_id'],
            'amount_raw' => $total_money,
            'price'      => money($total_money)
        ];
    }
}
function checkDisCode($code){
    global $ketnoi , $now;
    $code = antixss($_POST['discount']);
    if ($code == "") {
        json_Msg('error','Vui lòng nhập mã giảm giá');
    }

    $check_dis = $ketnoi->get_row("SELECT * FROM `discount` WHERE `code` = '$code'");
    if (!$check_dis) {
        json_Msg('error','Mã giảm giá không đúng');
    }

    if ($check_dis['used'] >= $check_dis['discount']) {
        json_Msg('error','Mã giảm giá đã hết lượt sử dụng');
    }

    if (($check_dis['enddate']) >= $now) {
        json_Msg('error','Mã giảm giá đã hết hạn');
    }

    $money = (float)($check_dis['amount'] ?? 0);
    $isPercent = ($check_dis['type'] === 'percent');

    return [
        'status'   => 'success',
        'discount' => $money,
        'price'    => $isPercent ? money($money) . '%' : money($money) . 'đ'
    ];
}
function checkDiscount($subtotal, $discount_input) {
    $discount_value = 0;
    if (is_numeric($discount_input) && $discount_input > 0) {
        $discount_input = (float)$discount_input;
        if ($discount_input < 100) {
            $discount_value = $subtotal * $discount_input / 100;
        } 
        elseif ($discount_input >= 1000) {
            $discount_value = $discount_input;
        }
    }
    return max($subtotal - $discount_value, 0);
}
function sendMail($mail_nhan, $ten_nhan, $chu_de, $noi_dung, $bcc = '', $path = '')
{
    global $ketnoi;
    if ($ketnoi->site('pass_email_smtp') != '') {
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = "html";
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $ketnoi->site('email_smtp');
        $mail->Password = $ketnoi->site('pass_email_smtp');
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom($ketnoi->site('email_smtp'), $bcc);
        $mail->addAddress($mail_nhan, $ten_nhan);
        $mail->addAttachment($path);
        $mail->addReplyTo($ketnoi->site('email_smtp'), $bcc);
        $mail->isHTML(true);
        $mail->Subject = $chu_de;
        $mail->Body    = $noi_dung;
        $mail->CharSet = 'UTF-8';
        $send = $mail->send();
        return $send;
    }
    return 'Chưa cấu hình SMTP';
}
function antixss($data)
{
    $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do {
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    } while ($old_data !== $data);

    $xoa = htmlspecialchars(addslashes(trim($data)));

    return $xoa;
}
function money($price) {
    return str_replace(",", ".", number_format($price));
}
function random($string, $int) {  
    return substr(str_shuffle($string), 0, $int);
}
function getOS()
{ // get thiết bị
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile',
    );

    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }

    return $os_platform;
}
function getTrinhDuyet()
{ 
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/coc_coc_browser/i' => 'Cốc Cốc',
    );

    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    return $browser;
}
function typePost($data) {
    $status = array(
        "tin-tuc" => 'Tin Tức',
        "huong-dan" => 'Hướng Dẫn',
        "khuyen-mai" => 'Khuyến Mãi',
    );
    if (array_key_exists($data, $status)) {
        return $status[$data];
    } else {
        return 'Chưa Xác Định';
    }
}
function status($data) {
    $status = array(
        "thanhcong" => '<span class="badge bg-success-subtle text-success">Thành Công</span>',
        "thatbai" => '<span class="badge bg-danger-subtle text-danger">Thất Bại</span>',
    );
    if (array_key_exists($data, $status)) {
        return $status[$data];
    }
}
function level($data) {
    $status = array(
        "1" => 'Quản Trị Viên',
        "3" => 'Đại Lý',
        "0" => 'Thành Viên',
    );
    if (array_key_exists($data, $status)) {
        return $status[$data];
    } else {
        return 'Chưa Đăng Nhập';
    }
}
function base_url($url)
{
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
    if ($base_url == 'https://localhost') {
        $base_url = 'https://localhost';
    }
    return $base_url . '/' . $url;
}
function to_slug($strTitle) {
    $strTitle=strtolower($strTitle);
    $strTitle=trim($strTitle);
    $strTitle=str_replace(' ','-',$strTitle);
    $strTitle=preg_replace("/(ò|ó|ọ|ỏ|õ|ơ|ờ|ớ|ợ|ở|ỡ|ô|ồ|ố|ộ|ổ|ỗ)/",'o',$strTitle);
    $strTitle=preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|Ô|Ố|Ổ|Ộ|Ồ|Ỗ)/",'o',$strTitle);
    $strTitle=preg_replace("/(à|á|ạ|ả|ã|ă|ằ|ắ|ặ|ẳ|ẵ|â|ầ|ấ|ậ|ẩ|ẫ)/",'a',$strTitle);
    $strTitle=preg_replace("/(À|Á|Ạ|Ả|Ã|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ)/",'a',$strTitle);
    $strTitle=preg_replace("/(ề|ế|ệ|ể|ê|ễ|é|è|ẻ|ẽ|ẹ)/",'e',$strTitle);
    $strTitle=preg_replace("/(Ể|Ế|Ệ|Ể|Ê|Ễ|É|È|Ẻ|Ẽ|Ẹ)/",'e',$strTitle);
    $strTitle=preg_replace("/(ừ|ứ|ự|ử|ư|ữ|ù|ú|ụ|ủ|ũ)/",'u',$strTitle);
    $strTitle=preg_replace("/(Ừ|Ứ|Ự|Ử|Ư|Ữ|Ù|Ú|Ụ|Ủ|Ũ)/",'u',$strTitle);
    $strTitle=preg_replace("/(ì|í|ị|ỉ|ĩ)/",'i',$strTitle);
    $strTitle=preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/",'i',$strTitle);
    $strTitle=preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/",'y',$strTitle);
    $strTitle=preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/",'y',$strTitle);
    $strTitle=str_replace('đ','d',$strTitle);
    $strTitle=str_replace('Đ','d',$strTitle);
    $strTitle=preg_replace("/[^-a-zA-Z0-9]/",'',$strTitle);
    return $strTitle;
}

function fmDate($date) {
    return date('H:i:s d/m/Y', $date);
}
function json_Msg($status,$text){
    exit(json_encode(array(
        'status' => $status, 
        'msg' => $text)
    ));
}
function TypePassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}
function verify_password($input_password, $hashed_password)
{
    return password_verify($input_password, $hashed_password);
}
function encryptData($data)
{
    global $rsa;
    $rsa->setPrivateKey(realpath($_SERVER["DOCUMENT_ROOT"]) . '/libs/client_private.pem');
    $rsa->setPublicKey(realpath($_SERVER["DOCUMENT_ROOT"]) . '/libs/server_public.pem');
    return $rsa->encryptWithPublicKey($data);
}

function decodecryptData($data)
{
    global $rsa;
    $rsa->setPrivateKey(realpath($_SERVER["DOCUMENT_ROOT"]) .'/libs/server_private.pem');
    $rsa->setPublicKey(realpath($_SERVER["DOCUMENT_ROOT"]) .'/libs/client_public.pem');
    return $rsa->decryptWithPrivateKey($data);
}

function check_address($ip_adr) {
    $access_token = "1486fa5ea4205f";
    $url = "https://ipinfo.io/{$ip_adr}/json?token={$access_token}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    curl_close($ch);
    if ($response) {
        $data = json_decode($response, true);
        return $data['city'] ?? false; 
    }
    return false;
}
function shortText($text, $limit = 40) {
	$text = trim($text);
	if (strlen($text) <= $limit) return htmlspecialchars($text);
	return htmlspecialchars(substr($text, 0, $limit)) . '...';
}

function parseDatetimeToTimestamp($value) {
    $value = trim((string)$value);
    if ($value === "") return 0;
    $ts = strtotime($value);
    return $ts ? $ts : 0;
} 

function validateEmail($email, $checkMx = false) {
    // Kiểm tra empty
    if (empty($email)) {
        return ['status' => true, 'message' => 'Email có thể để trống'];
    }
    
    // Kiểm tra độ dài
    if (strlen($email) > 255) {
        return ['status' => false, 'message' => 'Email không được quá 255 ký tự'];
    }
    
    // Validate format cơ bản
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['status' => false, 'message' => 'Email không đúng định dạng'];
    }
    
    // Kiểm tra ký tự đặc biệt
    if (preg_match('/[<>()\[\]\\;:,\"]/', $email)) {
        return ['status' => false, 'message' => 'Email chứa ký tự không hợp lệ'];
    } 
    
    return ['status' => true, 'message' => 'Email hợp lệ'];
}

function validatePhone($phone, $requireFormat = true) {
    // Kiểm tra empty
    if (empty($phone)) {
        return ['status' => true, 'message' => 'Số điện thoại có thể để trống', 'formatted' => ''];
    }
    
    // Xóa tất cả ký tự không phải số
    $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
    
    // Kiểm tra độ dài
    if (strlen($cleanPhone) < 10 || strlen($cleanPhone) > 11) {
        return ['status' => false, 'message' => 'Số điện thoại phải có 10-11 chữ số'];
    }
    
    // Kiểm tra đầu số Việt Nam (cập nhật đầy đủ)
    $validPrefixes = [
        // Viettel
        '032', '033', '034', '035', '036', '037', '038', '039',
        // MobiFone
        '070', '076', '077', '078', '079',
        // Vinaphone
        '081', '082', '083', '084', '085',
        // Vietnamobile
        '056', '058',
        // Gmobile
        '059',
        // Itelecom
        '087',
        // FPT (mới)
        '029', '028',
        // Viettel (mới)
        '096', '097', '098', '086',
        // Vinaphone (mới)
        '088', '089',
        // MobiFone (mới)
        '090', '093',
        // Vietnamobile (mới)
        '092', '094',
        // Gmobile (mới)
        '099', '095'
    ];
    
    $prefix3 = substr($cleanPhone, 0, 3);
    $prefix2 = substr($cleanPhone, 0, 2);
    
    $isValid = false;
    
    // Kiểm tra đầu 3 số
    if (in_array($prefix3, $validPrefixes)) {
        $isValid = true;
    }
    // Kiểm tra đầu 2 số (cho các đầu số cũ)
    elseif (in_array($prefix2, ['09', '08', '07', '05', '03'])) {
        $isValid = true;
    }
    
    if (!$isValid) {
        return ['status' => false, 'message' => 'Đầu số không hợp lệ. Số điện thoại Việt Nam bắt đầu bằng: 09, 08, 07, 05, 03'];
    }
    
    // Format số điện thoại nếu cần
    $formatted = $cleanPhone;
    if ($requireFormat) {
        if (strlen($cleanPhone) === 10) {
            $formatted = substr($cleanPhone, 0, 4) . ' ' . substr($cleanPhone, 4, 3) . ' ' . substr($cleanPhone, 7, 3);
        } elseif (strlen($cleanPhone) === 11) {
            $formatted = substr($cleanPhone, 0, 4) . ' ' . substr($cleanPhone, 4, 3) . ' ' . substr($cleanPhone, 7, 4);
        }
    }
    
    return ['status' => true, 'message' => 'Số điện thoại hợp lệ', 'formatted' => $formatted, 'clean' => $cleanPhone];
}

function formatPhoneNumber($phone) {
    $validate = validatePhone($phone, true);
    return $validate['status'] ? $validate['formatted'] : $phone;
}
?>
<?php require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'CARD_CHARGE') {
        $telco = antixss($_POST['telco']);
        $amount = antixss($_POST['amount']);
        $serial = antixss($_POST['serial']);
        $pin = antixss($_POST['pin']);
        if(!checkUser($username , $session)){
            json_Msg('error', 'Bạn không có quyền thực hiện hành động này');
        }elseif($telco == "" || $amount == "" || $serial == "" || $pin == ""){
            json_Msg('error', 'Vui lòng nhập đủ thông tin');
        }elseif(!(ctype_digit($pin))|| !(ctype_digit($serial))){
            json_Msg('error','Mã thẻ và số serial phải là số');
        }else{
            $trans_id = random('0123456789qwertyuiopasdfghjlkzxcvbnmQEWRWROIWCJHSCNJKFBJWQ', 22);
            $result = api_card($telco, $amount, $serial, $pin, $trans_id);
            if($result['status'] == 99){ 
                $ketnoi->begin_transaction();
                $insert_card = $ketnoi->insert("card_history",array(
                    'username' => $username,
                    'telco' => $telco,
                    'amount' => $amount,
                    'serial' => $serial,
                    'code' => $pin,
                    'request_id' => $trans_id,
                    'status' => 'PENDING',
                    'time' => $now,
                ));
                if($insert_card){
                    $ketnoi->commit();
                    json_Msg('success', 'Nạp thành công');
                }else{
                    $ketnoi->rollback();
                    json_Msg('error', 'Nạp thất bại');
                }
            }else{
                json_Msg('error', $result['message']);
            }
        }
    }
}
<?php
function getUrl($url, $method, $auth = null, $data = null)
{
    global $ketnoi;
    $curl = curl_init();
    $headers = [
        'Content-Type: application/json',
        'api-username: ' . $ketnoi->site('api_username'),
        'api-app: ' . $ketnoi->site('api_app'),
        'api-secret: ' . $ketnoi->site('api_secret'),
    ];
    if($auth != null){
        $headers[] = 'auth-token: ' . $auth;
    }
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers,
    ];
    if ($data) {
        $options[CURLOPT_POSTFIELDS] = json_encode($data);
    }
    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    if ($error) {
        return ['error' => 1, 'message' => $error];
    }
    return json_decode($response, true);
}
function getToken(){
    global $ketnoi;
    $res = get_curl("https://cloudserver.h2cloud.vn/api/agency/get-info","GET",$ketnoi->site('auth_token_vps'));
    if (isset($res['error']) && $res['error'] == 0) {
        return $ketnoi->site('auth_token_vps');
    }else{
        $data = array(
            'api-username' => $ketnoi->site('api_username'),
            'api-app' => $ketnoi->site('api_app'),
            'api-secret' => $ketnoi->site('api_secret'),
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://cloudserver.h2cloud.vn/api/agency/get-token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response, true);
        $ketnoi->update("options", array(
            'value' => $result['auth-token']),
         " `key` = 'auth_token_vps' ");
        return $result['auth-token'];
    }
}
function getProduct(){
    $auth = getToken();
    $res = getUrl('https://cloudserver.h2cloud.vn/api/agency/get-product','GET',$auth);
    return $res;
}
function getListOs(){
    $auth = getToken();
    $res = getUrl('https://cloudserver.h2cloud.vn/api/agency/get-list-os','GET',$auth);
    return $res;
}
function creatVps($id_vps , $billing_cycle, $os, $addon_cpu, $addon_ram, $addon_disk){
    $auth = getToken();
    $data = array(
        'product-id' => $id_vps,
        'billing-cycle' => $billing_cycle,
        'os' => $os,
        'quantity' => '1',
        'addon-cpu' => $addon_cpu,
        'addon-ram' => $addon_ram,
        'addon-disk' => $addon_disk,
    );
    $res = getUrl('https://cloudserver.h2cloud.vn/api/agency/order/create-order','POST',$auth,$data);
    return $res;
}
function getInfo(){
    $auth = getToken();
    $res = getUrl('https://cloudserver.h2cloud.vn/api/agency/get-info','GET',$auth);
    return $res;
}
function getListVps(){
    $auth = getToken();
    $res = getUrl('https://cloudserver.h2cloud.vn/api/agency/vps/get-list-vps','GET',$auth);
    return $res;
}
function getInfoVps($vps_id){
    $auth = getToken();
    $data = array(
        'vps-id' => is_array($vps_id) ? $vps_id : (int)$vps_id
    );
    $res = getUrl('https://cloudserver.h2cloud.vn/api/agency/vps/get-info-vps','GET',$auth,$data);
    return $res;
}
function actionVps($action, $vps_id){
    $auth = getToken();
    $data = array(
        'action' => $action,
        'vps-id' => $vps_id,
    );
    $res = getUrl('https://cloudserver.h2cloud.vn/api/agency/vps/action-vps','POST',$auth,$data);
    return $res;
}
function upgradeVPS($vps_id,$addon_cpu,$addon_ram,$addon_disk){
    $auth = getToken();
    $data = array(
        'action' => 'addon-vps',
        'vps-id' => $vps_id,
        'addon-cpu' => $addon_cpu,
        'addon-ram' => $addon_ram,
        'addon-disk' => $addon_disk,
    );
    $res = getUrl('https://cloudserver.h2cloud.vn/api/agency/vps/action-vps','POST',$auth,$data);
    return $res;
}
function reinstallVPS($vps_id,$os_id){
    $auth = getToken();
    $data = array(
        'action' => 'confirm-rebuild-vps',
        'vps-id' => $vps_id,
        'os-id' => $os_id,
    );
    $res = getUrl('https://cloudserver.h2cloud.vn/api/agency/vps/action-vps','POST',$auth,$data);
    return $res;
}
function renewVps($vps_id,$billing_cycle){
    $auth = getToken();
    $data = array(
        'action' => 'renew-vps',
        'vps-id' => $vps_id,
        'billing-cycle' => $billing_cycle
    );
    $res = getUrl('https://cloudserver.h2cloud.vn/api/agency/vps/action-vps','POST',$auth,$data);
    return $res;
}
function syncVpsList($vps_ids = [])
{
    global $ketnoi;
    if (empty($vps_ids)) return 0;
    $response = getInfoVps($vps_ids); 
    $json = is_array($response) ? $response : json_decode($response, true);

    if (empty($json['data']) || $json['error'] != 0) return 0;

    $updated = 0;
    $now = date('Y-m-d H:i:s');

    foreach ($json['data'] as $vps) {
        $vps_id = $vps['vps-id'];
        $info = [
            'ip' => $vps['ip'] ?? '',
            'cpu' => $vps['cpu'] ?? '',
            'ram' => $vps['ram'] ?? '',
            'disk' => $vps['disk'] ?? '',
            'text-config' => $vps['text-config'] ?? '',
            'day-left' => $vps['day-left'] ?? '',
            'username' => $vps['username'] ?? '',
            'password' => $vps['password'] ?? '',
        ];

        $status_api = $vps['vps-status'] ?? 'unknown';
        $old = $ketnoi->get_row("SELECT data, status FROM purchased_cloudvps WHERE id_vps='$vps_id'");

        $need_update = false;
        if ($old) {
            $old_data = json_decode($old['data'], true) ?? [];
            if (md5(json_encode($info)) !== md5(json_encode($old_data)) || $old['status'] !== $status_api) {
                $need_update = true;
            }
        } else $need_update = true;

        if ($need_update) {
            $ketnoi->update("purchased_cloudvps", [
                'data' => json_encode($info, JSON_UNESCAPED_UNICODE),
                'status' => $status_api,
                'updated_at' => $now
            ], "`id_vps`='$vps_id'");
            $updated++;
        }
    }
    return $updated;
}

// echo getToken();
// print_r(getListVps());
// print_r(upgradeVPS(4187, 1, 0, 10));
// print_r(creatVps(27, 'monthly', 8, 0, 0, 0));
// exit(json_encode(getListVps(27, 'monthly', 9,  0, 0, 0)));
?>

<?php 
function get_curl($url, $method, $auth = null, $data = null)
{
    global $ketnoi;
    $curl = curl_init();
    $headers = [
        'Content-Type: application/json',
        'api-username: chinhapiit@gmail.com',
        'api-app: RCGYS4HZceZJqOc49kdO80du',
        'api-secret: lZmJQn5FlLU54eUWhnw4p9HFXRnAHjsvUfxnDopnVXxad5PrK0gUk0zniQKZxOoYINv28ppFjwQWLc1RJfaAYQNH3dgJIgbkEdXIrgX0JWokxDladCwLpiYbnmfqqerY',
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
function get_token(){
    global $ketnoi;
    $res = get_curl("https://portal.vncloud.net/api/agency/get-info","GET",$ketnoi->site('auth_token_vps'));
    if (isset($res['error']) && $res['error'] == 0) {
        return $ketnoi->site('auth_token_vps');
    }else{
        $data = array(
            'api-username' => 'chinhapiit@gmail.com',
            'api-app' => 'RCGYS4HZceZJqOc49kdO80du',
            'api-secret' => 'lZmJQn5FlLU54eUWhnw4p9HFXRnAHjsvUfxnDopnVXxad5PrK0gUk0zniQKZxOoYINv28ppFjwQWLc1RJfaAYQNH3dgJIgbkEdXIrgX0JWokxDladCwLpiYbnmfqqerY',
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://portal.vncloud.net/api/agency/get-token',
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
function get_product()
{
    $auth = get_token();
    $res = get_curl('https://portal.vncloud.net/api/agency/get-product', 'GET', $auth);
    return $res;
}
function get_os(){
    $auth = get_token();
    $res = get_curl('https://portal.vncloud.net/api/agency/get-list-os','GET',$auth);
    return $res;
}


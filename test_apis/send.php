<?php
function sendPostRequest($url, $fields){
    $postvars = http_build_query($fields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
    $result = curl_exec($ch);
    curl_close($ch);
}

$apiFor = "Public_Login";

if($apiFor == "Admin_Login"){
    $fields = array(
    'username' => 'vivek',
    'password' => 'admin',
    );
    sendPostRequest("http://localhost/donation_app/admin_apis/login_api.php", $fields);
}
else if($apiFor == "Public_Login"){
    $fields = array(
    'phone' => '+918653826902',
    'password' => 'public',
    );
    sendPostRequest("http://localhost/donation_app/public_apis/login_api.php", $fields);
}
?>
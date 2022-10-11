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

$apiFor = "Get_Agent_List";

if($apiFor == "Admin_Login"){
    $fields = array(
    'username' => 'vivek',
    'password' => 'admin',
    );
    sendPostRequest("http://localhost/donation_app/admin_apis/login_api.php", $fields);
}
else if($apiFor == "Register_Agent"){
    $fields = array(
        'fullname' => 'Kunal Kapoor',
        'address' => 'Kolkata, Salt Lake',
        'phone' => '+918653758368',
        'email' => 'kunal.kapoor@mail.com',
        'password' => 'agent',
        'zone_from' => '713201',
        'zone_to' => '713212',
        'registered_on' => '11th Oct 2022'
    );
    sendPostRequest("http://localhost/donation_app/admin_apis/register_agent_api.php", $fields);
}
else if($apiFor == "Get_Agent_List"){
    $fields = array(
        'scriptPassword' => 'SaltedPassword'
    );
    sendPostRequest("http://localhost/donation_app/admin_apis/get_agent_list_api.php", $fields);
}
else if($apiFor == "Public_Login"){
    $fields = array(
    'phone' => '+918653826902',
    'password' => 'public',
    );
    sendPostRequest("http://localhost/donation_app/public_apis/login_api.php", $fields);
}
else if($apiFor == "Agent_Login"){
    $fields = array(
    'phone' => '+918653758368',
    'password' => 'agent',
    );
    sendPostRequest("http://localhost/donation_app/agent_apis/login_api.php", $fields);
}
?>
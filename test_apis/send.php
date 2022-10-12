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

$apiFor = "Change_Admin_Basic_Details";

if($apiFor == "Admin_Login"){
    $fields = array(
    'username' => 'vivek',
    'password' => 'admin',
    );
    sendPostRequest("http://localhost/donation_app/admin_apis/login_api.php", $fields);
}
else if($apiFor == "Change_Admin_Password"){
    $fields = array(
    'admin_id' => '1',
    'currentPassword' => 'admin',
    'newPassword' => 'somewhat',
    'confirmPassword' => 'somewhat'
    );
    sendPostRequest("http://localhost/donation_app/admin_apis/change_password_api.php", $fields);
}
else if($apiFor == "Change_Admin_Basic_Details"){
    $fields = array(
    'admin_id' => '1',
    'fullname' => 'Igloo',
    'phone' => '9638527410',
    'email' => 'admin@donate.com',
    'password' => 'admin',
    );
    sendPostRequest("http://localhost/donation_app/admin_apis/change_basic_details_api.php", $fields);
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
else if($apiFor == "Get_Public_List"){
    $fields = array(
        'scriptPassword' => 'SaltedPassword'
    );
    sendPostRequest("http://localhost/donation_app/admin_apis/get_public_list_api.php", $fields);
}
else if($apiFor == "Public_Login"){
    $fields = array(
    'phone' => '+918653826902',
    'password' => 'public',
    );
    sendPostRequest("http://localhost/donation_app/public_apis/login_api.php", $fields);
}
else if($apiFor == "Change_Public_Password"){
    $fields = array(
    'public_id' => '7',
    'currentPassword' => 'public1',
    'newPassword' => 'vivek',
    'confirmPassword' => 'vivek'
    );
    sendPostRequest("http://localhost/donation_app/public_apis/change_password_api.php", $fields);
}
else if($apiFor == "Change_Public_Basic_Details"){
    $fields = array(
    'public_id' => '7',
    'fullname' => 'Hrithik',
    'phone' => '7418529630',
    'email' => 'vivek@ok.in',
    'address' => 'Hastinapur',
    'pincode' => '789456',
    'password' => 'vivek',
    );
    sendPostRequest("http://localhost/donation_app/public_apis/change_basic_details_api.php", $fields);
}
else if($apiFor == "Fetch_Feed"){
    $fields = array(
    'lastPostId' => '0',
    'postLimit' => '5',
    );
    sendPostRequest("http://localhost/donation_app/public_apis/fetch_feed_api.php", $fields);
}
else if($apiFor == "Update_Wallet_Amount"){
    $fields = array(
    'public_id' => '5',
    'amount' => '5',
    'status' => 'Active',
    );
    sendPostRequest("http://localhost/donation_app/public_apis/update_wallet_amount_api.php", $fields);
}
else if($apiFor == "Agent_Login"){
    $fields = array(
    'phone' => '+918653758368',
    'password' => 'agent',
    );
    sendPostRequest("http://localhost/donation_app/agent_apis/login_api.php", $fields);
}
?>
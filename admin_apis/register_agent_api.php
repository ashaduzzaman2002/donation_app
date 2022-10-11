<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus[0]["error"] = false;
$processStatus[0]["message"] = "No Error";

$mandatoryVal = isset($_POST["fullname"]) && isset($_POST["address"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["zone_from"]) && isset($_POST["zone_to"]) && isset($_POST["registered_on"]);

if($mandatoryVal){
    $fullname = getSafeValue($_POST['fullname']);
    $address = getSafeValue($_POST['address']);
    $phone = getSafeValue($_POST['phone']);
    $email = getSafeValue($_POST['email']);
    $password = getSafeValue($_POST['password']);
    $zone_from = getSafeValue($_POST['zone_from']);
    $zone_to = getSafeValue($_POST['zone_to']);
    $registered_on = getSafeValue($_POST['registered_on']);

    // Validation Part
    if($processStatus[0]["error"] == false && strlen($phone) == 13 && strlen($password) > 0){

        // Data Inserting Part
        $sql= "Insert into agent set
        fullname = '$fullname',
        address = '$address',
        phone = '$phone',
        email = '$email',
        password = '$password',
        zone_from = '$zone_from',
        zone_to = '$zone_to',
        registered_on = '$registered_on'
        ";
        $conn->query($sql);
        if($conn->affected_rows > 0){
            $processStatus[0]["error"] = false;
            $processStatus[0]["message"] = "Agent Registered";
        }else{
            // Error Part
            $processStatus[0]["error"] = true;
            $processStatus[0]["message"] = "No such account";
        }
    } else{
        // Error Part
        $processStatus[0]["error"] = true;
        $processStatus[0]["message"] = "Sent Invalid Data. Please check.";
    }
}else{
    // Error Part
    $processStatus[0]["error"] = true;
    $processStatus[0]["message"] = "FN, PHN, EM, ADR, ZF, ZT, RO, PSS is mandatory.";
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($processStatus);
?>
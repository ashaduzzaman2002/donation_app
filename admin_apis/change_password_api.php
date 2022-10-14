<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

$mandatoryVal = isset($_POST["admin_id"]) && isset($_POST["currentPassword"]) && isset($_POST["newPassword"]) && isset($_POST["confirmPassword"]);

if($mandatoryVal){
    $admin_id = getSafeValue($_POST['admin_id']);
    $currentPassword = getSafeValue($_POST['currentPassword']);
    $newPassword = getSafeValue($_POST['newPassword']);
    $confirmPassword = getSafeValue($_POST['confirmPassword']);

    // Validation Part
    if($processStatus["error"] == false && $admin_id > 0 && strlen($currentPassword) >= 3 && strlen($newPassword) >= 3 && strlen($confirmPassword) >= 3 && $newPassword == $confirmPassword){

        // Data Checking Part
        $sql= "Select * from admin where id='$admin_id' and password = '$currentPassword' LIMIT 1";
        $res = $conn->query($sql);
        if($res->num_rows > 0){
            $conn->query("Update admin set 
            password = '$newPassword' 
            where id = '$admin_id' and password ='$currentPassword'
            ");
            if($conn->affected_rows > 0){
                $processStatus["error"] = false;
                $processStatus["message"] = "Password Changed.";
            }else{
                // Error Part
                $processStatus["error"] = true;
                $processStatus["message"] = "Database Query Error. Approach Administrator. ";
            }
        }else{
            // Error Part
            $processStatus["error"] = true;
            $processStatus["message"] = "No such account.";
        }
    } else{
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "Sent Invalid Data. Please check.";
    }
}else{
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "CURRPSS, NWPSS, CNFPSS is mandatory.";
}
mysqli_close($conn);
echo json_encode($processStatus);
?>
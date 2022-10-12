<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus[0]["error"] = false;
$processStatus[0]["message"] = "No Error";

$mandatoryVal = isset($_POST["public_id"]) && isset($_POST["currentPassword"]) && isset($_POST["newPassword"]) && isset($_POST["confirmPassword"]);

if($mandatoryVal){
    $public_id = getSafeValue($_POST['public_id']);
    $currentPassword = getSafeValue($_POST['currentPassword']);
    $newPassword = getSafeValue($_POST['newPassword']);
    $confirmPassword = getSafeValue($_POST['confirmPassword']);

    // Validation Part
    if($processStatus[0]["error"] == false && $public_id > 0 && strlen($currentPassword) >= 3 && strlen($newPassword) >= 3 && strlen($confirmPassword) >= 3 && $newPassword == $confirmPassword){

        // Data Checking Part
        $sql= "Select * from public where password = '$currentPassword' LIMIT 1";
        $res = $conn->query($sql);
        if($res->num_rows > 0){
            $conn->query("Update public set 
            password = '$newPassword' 
            where id = '$public_id' and password ='$currentPassword'
            ");
            if($conn->affected_rows > 0){
                $processStatus[0]["error"] = false;
                $processStatus[0]["message"] = "Password Changed.";
            }else{
                // Error Part
                $processStatus[0]["error"] = true;
                $processStatus[0]["message"] = "Database Query Error. Approach Administrator. ";
            }
        }else{
            // Error Part
            $processStatus[0]["error"] = true;
            $processStatus[0]["message"] = "No such account.";
        }
    } else{
        // Error Part
        $processStatus[0]["error"] = true;
        $processStatus[0]["message"] = "Sent Invalid Data. Please check.";
    }
}else{
    // Error Part
    $processStatus[0]["error"] = true;
    $processStatus[0]["message"] = "CURRPSS, NWPSS, CNFPSS is mandatory.";
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($processStatus);
?>
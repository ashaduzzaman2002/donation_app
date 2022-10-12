<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus[0]["error"] = false;
$processStatus[0]["message"] = "No Error";

$mandatoryVal = isset($_POST["admin_id"]) && isset($_POST["fullname"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["password"]);

if($mandatoryVal){
    $admin_id = getSafeValue($_POST['admin_id']);
    $fullname = getSafeValue($_POST['fullname']);
    $phone = "+91".getSafeValue($_POST['phone']);
    $email = getSafeValue($_POST['email']);
    $password = getSafeValue($_POST['password']);

    // Validation Part
    if($processStatus[0]["error"] == false && $admin_id > 0 && strlen($phone) == 13){

        // Data Checking Part
        $sql= "Select * from admin where id='$admin_id' and password = '$password' LIMIT 1";
        $res = $conn->query($sql);
        if($res->num_rows > 0){
            $conn->query("Update admin set 
            fullname = '$fullname',
            phone = '$phone',
            email = '$email'
            where id = '$admin_id' and password ='$password'
            ");
            if($conn->affected_rows > 0){
                $processStatus[0]["error"] = false;
                $processStatus[0]["message"] = "Basic Details Updated.";
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
    $processStatus[0]["message"] = "FN, ADDR, PIN, PHN, EM, ID, PWD is mandatory.";
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($processStatus);
?>
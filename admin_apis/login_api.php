<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus[0]["error"] = false;
$processStatus[0]["message"] = "No Error";

$mandatoryVal = isset($_POST["username"]) && isset($_POST["password"]);

if($mandatoryVal){
    $username = getSafeValue($_POST['username']);
    $password = getSafeValue($_POST['password']);

    // Validation Part
    if($processStatus[0]["error"] == false && strlen($username) > 0 && strlen($password) > 0){

        // Data fetching Part
        $userData = array();
        $sql= "Select * from admin where username = '$username' and password = '$password' LIMIT 1";
        $res = $conn->query($sql);
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $processStatus[0]['response'] = $row;
            }
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
    $processStatus[0]["message"] = "Username and Password is mandatory.";
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($processStatus);
?>
<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus[0]["error"] = false;
$processStatus[0]["message"] = "No Error";

$mandatoryVal = isset($_POST["phone"]) && isset($_POST["password"]);

if($mandatoryVal){
    $phone = getSafeValue($_POST['phone']);
    $password = getSafeValue($_POST['password']);

    // Validation Part
    if($processStatus[0]["error"] == false && strlen($phone) > 0 && strlen($password) > 0){

        // Data fetching Part
        $sql= "Select * from public where phone = '$phone' and password = '$password' LIMIT 1";
        $res = $conn->query($sql);
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $row['photo'] = "../assets/public_files/".$row['photo'];
                $row['adhaar'] = "../assets/public_files/".$row['adhaar'];
                $row['pan'] = "../assets/public_files/".$row['pan'];
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
    $processStatus[0]["message"] = "Phone and Password is mandatory.";
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($processStatus);
?>
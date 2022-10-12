<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus[0]["error"] = false;
$processStatus[0]["message"] = "No Error";

$mandatoryVal = isset($_POST["public_id"]) && isset($_POST["amount"]) && isset($_POST["status"]);

if($mandatoryVal){
    $public_id = getSafeValue($_POST['public_id']);
    $amount = getSafeValue($_POST['amount']);
    $status = getSafeValue($_POST['status']);

    // Validation Part
    if($processStatus[0]["error"] == false && $public_id > 0){

        // Data Inserting Part
        $sql= "Update wallet set
        amount += '$amount',
        status = '$status'
        where public_id = '$public_id'
        ";
        $conn->query($sql);
        if($conn->affected_rows > 0){
            $processStatus[0]["error"] = false;
            $processStatus[0]["message"] = "Wallet Amount Updated";
        }else{
            // Error Part
            $processStatus[0]["error"] = true;
            $processStatus[0]["message"] = "No such wallet";
        }
    } else{
        // Error Part
        $processStatus[0]["error"] = true;
        $processStatus[0]["message"] = "Sent Invalid Data. Please check.";
    }
}else{
    // Error Part
    $processStatus[0]["error"] = true;
    $processStatus[0]["message"] = "Public_id, Amount, Status is mandatory.";
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($processStatus);
?>
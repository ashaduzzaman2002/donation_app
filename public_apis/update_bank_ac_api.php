<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus[0]["error"] = false;
$processStatus[0]["message"] = "No Error";

$mandatoryVal = isset($_POST["public_id"]) && isset($_POST["account_number"]) && isset($_POST["ifsc_code"]) && isset($_POST["bank_name"]) && isset($_POST["ac_holder_name"]);

if($mandatoryVal){
    $public_id = getSafeValue($_POST['public_id']);
    $account_number = getSafeValue($_POST['account_number']);
    $ifsc_code = getSafeValue($_POST['ifsc_code']);
    $bank_name = getSafeValue($_POST['bank_name']);
    $ac_holder_name = getSafeValue($_POST['ac_holder_name']);

    // Validation Part
    if($processStatus[0]["error"] == false && $public_id > 0){

        $res = $conn->query("Select * from bank_account where public_id = '$public_id'");
        if($res->num_rows > 0){
            $conn->query("Update bank_account set
            account_number = '$account_number',
            ifsc_code = '$ifsc_code',
            bank_name = '$bank_name',
            ac_holder_name = '$ac_holder_name'
            where public_id = '$public_id'
            ");

            if($conn->affected_rows > 0){
                $processStatus[0]["error"] = false;
                $processStatus[0]["message"] = "Bank Account Updated";
            } else{
                $processStatus[0]["error"] = false;
                $processStatus[0]["message"] = "Database Query Error. Approach Administrator";
            }
        } else{
            $conn->query("Insert into bank_account set
            public_id = '$public_id',
            account_number = '$account_number',
            ifsc_code = '$ifsc_code',
            bank_name = '$bank_name',
            ac_holder_name = '$ac_holder_name'
            ");
            if($conn->affected_rows > 0){
                $processStatus[0]["error"] = false;
                $processStatus[0]["message"] = "Bank Account added";
            } else{
                $processStatus[0]["error"] = false;
                $processStatus[0]["message"] = "Database Query Error. Approach Administrator";
            }
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
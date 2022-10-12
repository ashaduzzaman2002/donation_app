<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus[0]["error"] = false;
$processStatus[0]["message"] = "No Error";

if($_POST['scriptPassword'] == "SaltedPassword"){
        // Data fetching Part
        $userData = array();
        $sql= "Select * from public";
        $res = $conn->query($sql);
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $row['photo'] = "../assets/public_files/".$row['photo'];
                $row['adhaar'] = "../assets/public_files/".$row['adhaar'];
                $row['pan'] = "../assets/public_files/".$row['pan'];
                $userData[count($userData)] = $row;
            }
            $processStatus[0]['response'] = $userData;
        }else{
            // Error Part
            $processStatus[0]["error"] = true;
            $processStatus[0]["message"] = "Database Query Error. Approach Administrator.";
        }
}else{
    // Error Part
    $processStatus[0]["error"] = true;
    $processStatus[0]["message"] = "Invalid Access";
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($processStatus);
?>
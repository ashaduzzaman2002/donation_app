<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

if(isset($_POST['scriptPassword']) && $_POST['scriptPassword'] == "SaltedPassword"){
        // Data fetching Part
        $userData = array();
        $sql= "Select * from gallery";
        $res = $conn->query($sql);
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $row['photo'] = "../assets/gallery_files/".$row['photo'];
                $userData[count($userData)] = $row;
            }
            $processStatus['response'] = json_encode($userData);
        }else{
            // Error Part
            $processStatus["error"] = true;
            $processStatus["message"] = "Database Query Error. Approach Administrator.";
        }
}else{
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "Invalid Access";
}
mysqli_close($conn);
echo json_encode($processStatus);
?>
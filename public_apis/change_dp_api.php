<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus[0]["error"] = false;
$processStatus[0]["message"] = "No Error";

$mandatoryVal = isset($_POST["public_id"]) && isset($_POST["old_dp"]);

if($mandatoryVal){
    $public_id = getSafeValue($_POST['public_id']);
    $old_dp = $_POST['old_dp'];

    if($_FILES['new_dp']['name'] != "" && round($_FILES['new_dp']['size'] /1024 /1024, 2) <= 2.00){

        $photoName = $_FILES['new_dp']['name'];
       
        if(!is_dir("../assets/public_files/")) {
            //mkdir("assets"); 
            mkdir("../assets/public_files"); 
        }
        //For new Profile picture Naming
        $rawBaseName = uniqid();
        $extension = pathinfo($photoName, PATHINFO_EXTENSION ) != '' ? pathinfo($photoName, PATHINFO_EXTENSION ) : 'jpg';
        $counter = 0;
        $photoName = $rawBaseName . '.' . $extension;
        while(file_exists("../assets/public_files/".$photoName)) {
            $photoName = $rawBaseName . $counter . '.' . $extension;
            $counter++;
        }
    } else{
        $processStatus[0]["error"] = true;
        $processStatus[0]["message"] = "Invalid Pictures! Check Size or Sent no image.";
    }

    // Will satisfy only when all validation is true
    if($processStatus[0]['error'] == false){

        if(move_uploaded_file($_FILES['new_dp']['tmp_name'],"../assets/public_files/".$photoName)){
            // Data Inserting Part
            unlink("../assets/public_files/".$old_dp);

            $conn->query("Update public set
            photo = '$photoName'
            where id = '$public_id'
            ");
            if($conn->affected_rows > 0){
                $processStatus[0]["error"] = false;
                $processStatus[0]["message"] = "Dp Changed";
            } else{
                // Error Part
                $processStatus[0]["error"] = true;
                $processStatus[0]["message"] = "Database Query Error. Approach Administrator.";
            }
        } else{
            // Error Part
            $processStatus[0]["error"] = true;
            $processStatus[0]["message"] = "File upload failed. Try again.";
        }
    } 
} else{
    // Error Part
    $processStatus[0]["error"] = true;
    $processStatus[0]["message"] = "FN, PHN, EM, PSS, ADR, PIN, RBY, RO  is mandatory.";
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($processStatus);
?>
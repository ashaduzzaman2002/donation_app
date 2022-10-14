<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

if(isset($_POST["scriptPassword"]) && getSafeValue($_POST['scriptPassword']) == "SaltedPassword" && isset($_POST["imageId"])){

    $imageId = getSafeValue($_POST['imageId']);

    // Validation Part
    if($processStatus["error"] == false && $imageId > 0){

        // Data fetching Part
        $res = $conn->query("Select * from gallery where id = '$imageId'");
        if($res->num_rows == 1){
            $row = $res->fetch_assoc();
            if(unlink("../assets/gallery_files/".$row['photo'])){
                $conn->query("Delete from gallery where id = '$imageId'");
                if($conn->affected_rows > 0){
                    $processStatus["error"] = false;
                    $processStatus["message"] = "Gallery Image Deleted.";
                } else{
                    $processStatus["error"] = true;
                    $processStatus["message"] = "Database Query Error. Approach Administrator.";
                }
            } else{
                $processStatus["error"] = true;
                $processStatus["message"] = "Gallery image couldn't be deleted.";
            }
        } else{
            $processStatus["error"] = true;
            $processStatus["message"] = "No such image available.";
        }
    } else{
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "Sent Invalid Data. Please check.";
    }
}else{
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "Image id is mandatory.";
}
mysqli_close($conn);
// header('Content-Type: application/json');
echo json_encode($processStatus);
?>
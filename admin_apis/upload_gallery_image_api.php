<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

$mandatoryVal = isset($_POST["caption"]);

if($mandatoryVal){
    $caption = getSafeValue($_POST['caption']);

    if($_FILES['gallery_photo']['name'] != "" && round($_FILES['gallery_photo']['size'] /1024 /1024, 2) <= 5.00){
        $photoName = $_FILES['gallery_photo']['name'];
        if(!is_dir("../assets/gallery_files/")) {
            //mkdir("assets"); 
            mkdir("../assets/gallery_files"); 
        }
        //For new gallery picture Naming
        $rawBaseName = uniqid();
        $extension = pathinfo($photoName, PATHINFO_EXTENSION ) != '' ? pathinfo($photoName, PATHINFO_EXTENSION ) : 'jpg';
        $counter = 0;
        $photoName = $rawBaseName . '.' . $extension;
        while(file_exists("../assets/gallery_files/".$photoName)) {
            $photoName = $rawBaseName . $counter . '.' . $extension;
            $counter++;
        }
    } else{
        $processStatus["error"] = true;
        $processStatus["message"] = "Invalid Pictures! Check Size or Sent no image.";
    }
    // Will satisfy only when all validation is true
    if($processStatus['error'] == false){
        if(move_uploaded_file($_FILES['gallery_photo']['tmp_name'],"../assets/gallery_files/".$photoName)){
            // Data Inserting Part
            $conn->query("Insert into gallery set
            caption = '$caption',
            photo = '$photoName'
            ");
            if($conn->affected_rows > 0){
                $processStatus["error"] = false;
                $processStatus["message"] = "Photo Uploaded";
            } else{
                // Error Part
                $processStatus["error"] = true;
                $processStatus["message"] = "Database Query Error. Approach Administrator.";
            }
        } else{
            // Error Part
            $processStatus["error"] = true;
            $processStatus["message"] = "File upload failed. Try again.";
        }
    } 
} else{
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "CPT, PHO  is mandatory.";
}
mysqli_close($conn);
// header('Content-Type: application/json');
echo json_encode($processStatus);
?>